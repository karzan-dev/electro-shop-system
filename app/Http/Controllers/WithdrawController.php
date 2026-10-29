<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    /**
     * Calculate all financial stats with correct logic:
     * - Check if invoice_number exists in both sales and loans
     * - If exists in loans: use loans.currency instead of sales.total
     * - If only in sales: use sales.total
     */
private function calculateStats()
{
    $salesInvoices = DB::table('sales')->pluck('invoice_number')->toArray();
    $loanInvoices = DB::table('loans')->pluck('invoice_number')->toArray();
    $commonInvoices = array_intersect($salesInvoices, $loanInvoices);
    $salesOnlyInvoices = array_diff($salesInvoices, $loanInvoices);
    
    // 1. Sales NOT in loans (فرۆشی ڕاستەوخۆ)
    $totalSales = DB::table('sales')
        ->whereIn('invoice_number', $salesOnlyInvoices)
        ->sum('total') ?? 0;
    
    // 2. Loans currency for common invoices
    // loans.currency هەموو پارە وەرگیراوەکانی لەخۆدەگرێت (پێشەکی + قیستەکان)
    $totalLoanCurrencyForCommonInvoices = DB::table('loans')
        ->whereIn('invoice_number', $commonInvoices)
        ->sum('currency') ?? 0;
    
    // 3. Total discount
    $totalDiscount = DB::table('sales')->sum('discount') ?? 0;
    
    // 4. Loans currency ONLY in loans
    // loans.currency هەموو پارە وەرگیراوەکانی لەخۆدەگرێت
    $totalLoanCurrencyOnly = DB::table('loans')
        ->whereNotIn('invoice_number', $salesInvoices)
        ->sum('currency') ?? 0;
    
    // 5. Initial cash
    $totalCasherCoin = DB::table('casher_coin')->sum('amount') ?? 0;
    
    // 6. Total withdrawn
    $totalWithdraws = DB::table('withdraws')->sum('amount') ?? 0;
    
    // Cash in drawer - تەنها loans.currency بەکار دێت
    // نەک installments چونکە loans.currency هەمان شتە
    $cashInDrawer = ($totalCasherCoin 
                    + $totalSales 
                    + $totalLoanCurrencyForCommonInvoices 
                    + $totalLoanCurrencyOnly) 
                    - $totalWithdraws;
    
    return [
        'total_sales' => $totalSales,
        'total_discount' => $totalDiscount,
        'total_casher_coin' => $totalCasherCoin,
        'total_withdraws' => $totalWithdraws,
        'cash_in_drawer' => $cashInDrawer,
    ];
}
    public function index(Request $request)
    {
        $stats = $this->calculateStats();

        $query = DB::table('withdraws');

        if ($request->start_date) {
            $query->whereDate('withdraws.created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('withdraws.created_at', '<=', $request->end_date);
        }

        $withdraws = $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                $item->created_at = \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');
                return $item;
            });

        $lastWithdraw = $withdraws->first();

        if ($request->ajax() || $request->has('start_date') || $request->has('end_date')) {
            return response()->json([
                'success' => true,
                'data' => $withdraws,
                'stats' => array_merge($stats, [
                    'cash_before_withdraw' => $lastWithdraw ? $lastWithdraw->cash_before_withdraw : $stats['cash_in_drawer'],
                    'cash_after_withdraw' => $lastWithdraw ? $lastWithdraw->cash_after_withdraw : $stats['cash_in_drawer'],
                ])
            ]);
        }

        return view('items.withdrawals', array_merge($stats, [
            'lastCashBeforeWithdraw' => $lastWithdraw ? $lastWithdraw->cash_before_withdraw : $stats['cash_in_drawer'],
            'lastCashAfterWithdraw' => $lastWithdraw ? $lastWithdraw->cash_after_withdraw : $stats['cash_in_drawer'],
        ]));
    }

    public function history(Request $request)
    {
        $stats = $this->calculateStats();

        $query = DB::table('withdraws');

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $withdraws = $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                $item->created_at = \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i');
                return $item;
            });

        $lastWithdraw = $withdraws->first();

        return response()->json([
            'success' => true,
            'data' => $withdraws,
            'stats' => array_merge($stats, [
                'cash_before_withdraw' => $lastWithdraw ? $lastWithdraw->cash_before_withdraw : $stats['cash_in_drawer'],
                'cash_after_withdraw' => $lastWithdraw ? $lastWithdraw->cash_after_withdraw : $stats['cash_in_drawer'],
            ])
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:999999.99',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا',
                'errors' => $validator->errors()
            ], 422);
        }

        // Use the same calculation method
        $stats = $this->calculateStats();
        $cashInDrawer = $stats['cash_in_drawer'];
        $cashAfterWithdraw = $cashInDrawer - $request->amount;

        if ($request->amount > $cashInDrawer) {
            return response()->json([
                'success' => false,
                'message' => 'بڕی پارە زیاترە لە پارەی ناو قاسە'
            ], 422);
        }

        try {
            DB::table('withdraws')->insert([
                'amount' => $request->amount,
                'note' => $request->note,
                'cash_before_withdraw' => $cashInDrawer,
                'cash_after_withdraw' => $cashAfterWithdraw,
                'user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'پارە بە سەرکەوتوویی ڕاکێشرا'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا، تکایە دووبارە هەوڵبدەوە'
            ], 500);
        }
    }


     public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:999999.99',
            'note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Find the withdraw record
            $withdraw = DB::table('withdraws')->where('id', $id)->first();
            
            if (!$withdraw) {
                return response()->json([
                    'success' => false,
                    'message' => 'ڕاکێشانی پارە نەدۆزرایەوە'
                ], 404);
            }

            // Get current stats to check if new amount is valid
            $stats = $this->calculateStats();
            $cashInDrawer = $stats['cash_in_drawer'] + $withdraw->amount; // Add back the old amount
            
            if ($request->amount > $cashInDrawer) {
                return response()->json([
                    'success' => false,
                    'message' => 'بڕی پارە زیاترە لە پارەی ناو قاسە'
                ], 422);
            }

            // Calculate new cash after withdraw for this record
            $cashAfterWithdraw = $withdraw->cash_before_withdraw - $request->amount;

            // Update the record
            DB::table('withdraws')
                ->where('id', $id)
                ->update([
                    'amount' => $request->amount,
                    'note' => $request->note,
                    'cash_after_withdraw' => $cashAfterWithdraw,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'ڕاکێشانی پارە بە سەرکەوتوویی نوێکرایەوە'
            ]);

        } catch (\Exception $e) {
            Log::error('Withdraw update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا، تکایە دووبارە هەوڵبدەوە'
            ], 500);
        }
    }

    /**
     * Delete a specific withdraw record
     * 
     * IMPORTANT: Deleting a withdraw record does NOT recalculate
     * subsequent records' cash_before_withdraw and cash_after_withdraw values.
     * This maintains the historical snapshot of what was in the drawer at that time.
     */
    public function destroy($id)
    {
        try {
            // Find the withdraw record
            $withdraw = DB::table('withdraws')->where('id', $id)->first();
            
            if (!$withdraw) {
                return response()->json([
                    'success' => false,
                    'message' => 'ڕاکێشانی پارە نەدۆزرایەوە'
                ], 404);
            }

            // Delete the record
            DB::table('withdraws')
                ->where('id', $id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'ڕاکێشانی پارە بە سەرکەوتوویی سڕایەوە'
            ]);

        } catch (\Exception $e) {
            Log::error('Withdraw delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا، تکایە دووبارە هەوڵبدەوە'
            ], 500);
        }
    }

}