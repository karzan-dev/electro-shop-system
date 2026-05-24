<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
class CreateDailyAccountingController extends Controller

{

    /**
     * Get all cashiers (users with role 'Casher')
     */

    /**
     * Get all cashiers (users with role 'Casher')
     */
    public function getData()
    {
        try {
            $users = DB::table('users')
                ->where('role', '2')
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading cashiers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cashier details with daily summary
     */
    public function getDetails($id)
    {
        try {
            // Get cashier info
            $cashier = DB::table('users')
                ->where('id', $id)
                ->where('role', '2')
                ->select('id', 'name')
                ->first();

            if (!$cashier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cashier not found'
                ], 404);
            }

            // Get today's date
            $today = now()->format('Y-m-d');
            
            // Get today's sales summary
            $todaySales = DB::table('sales')
                ->where('user_id', $id)
                ->whereDate('created_at', $today)
                ->select(
                    DB::raw('COUNT(*) as invoice_count'),
                    DB::raw('COALESCE(SUM(total), 0) as total_sales'),
                    DB::raw('COALESCE(SUM(discount), 0) as total_discount'),
                    DB::raw('COALESCE(SUM(subtotal), 0) as subtotal')
                )
                ->first();

            // Get today's returns
            $todayReturns = DB::table('return_items')
                ->where('Casher_id', $id)
                ->whereDate('Return_Date', $today)
                ->select(
                    DB::raw('COALESCE(SUM(Return_Total), 0) as total_returns'),
                    DB::raw('COUNT(*) as return_count')
                )
                ->first();

            // Get casher_coin for today
            $casherCoin = DB::table('casher_coin')
                ->where('casher_id', $id)
                ->whereDate('created_at', $today)
                ->select(
                    DB::raw('COALESCE(SUM(amount), 0) as total_amount'),
                    DB::raw('COUNT(*) as transaction_count')
                )
                ->first();

            // Get last casher_coin record
            $lastCoinTransaction = DB::table('casher_coin')
                ->where('casher_id', $id)
                ->orderBy('created_at', 'desc')
                ->first();

            return response()->json([
                'success' => true,
                'name' => $cashier->name,
                'today_sales' => $todaySales->total_sales ?? 0,
                'today_discount' => $todaySales->total_discount ?? 0,
                'today_subtotal' => $todaySales->subtotal ?? 0,
                'invoice_count' => $todaySales->invoice_count ?? 0,
                'total_returns' => $todayReturns->total_returns ?? 0,
                'return_count' => $todayReturns->return_count ?? 0,
                'casher_coin_total' => $casherCoin->total_amount ?? 0,
                'casher_coin_transactions' => $casherCoin->transaction_count ?? 0,
                'last_coin_transaction' => $lastCoinTransaction ? [
                    'amount' => $lastCoinTransaction->amount,
                    'date' => $lastCoinTransaction->created_at
                ] : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading cashier details: ' . $e->getMessage()
            ], 500);
        }
    }

 /**
     * Get invoices for a specific cashier
     */

    /**
     * Get invoices for a specific cashier
     */
    public function getInvoices(Request $request)
    {
        try {
            $cashierId = $request->input('cashier_id');
            
            if (!$cashierId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cashier ID is required'
                ], 400);
            }

            // Get sales with related data
            $invoices = DB::table('sales')
                ->join('users', 'sales.user_id', '=', 'users.id')
                ->where('sales.user_id', $cashierId)
                ->select(
                    'sales.id',
                    'sales.invoice_number',
                    'sales.user_id',
                    'users.name as cashier_name',
                    'sales.total as total_sales',
                    'sales.discount as total_discount',
                    'sales.subtotal',
                 
                    'sales.created_at as date',
                    DB::raw('DATE(sales.created_at) as accountingDate')
                )
                ->orderBy('sales.created_at', 'desc')
                ->get();

            // For each sale, get the returns and casher_coin
            $invoicesWithDetails = $invoices->map(function ($invoice) {
                // Get returns for this date and cashier
                $returns = DB::table('return_items')
                    ->where('Casher_id', $invoice->user_id)
                    ->whereDate('Return_Date', $invoice->accountingDate)
                    ->select(
                        DB::raw('COALESCE(SUM(Return_Total), 0) as total_returns')
                    )
                    ->first();

                // Get casher_coin for this date and cashier
                $casherCoin = DB::table('casher_coin')
                    ->where('casher_id', $invoice->user_id)
                    ->whereDate('created_at', $invoice->accountingDate)
                    ->select(
                        DB::raw('COALESCE(SUM(amount), 0) as total_amount')
                    )
                    ->first();

                $totalReturns = $returns->total_returns ?? 0;
                $casherCoinAmount = $casherCoin->total_amount ?? 0;
                $netReturns =  ($invoice->total_sales ?? 0) - $totalReturns - ($invoice->total_discount ?? 0) + $casherCoinAmount;
                
                // Calculate profit
                $profit = $this->calculateProfit($invoice->id);
                
                // Calculate account balance considering casher_coin
                // Formula: Sales - Returns - Discounts + Casher Coin
                $netBalance = ($invoice->total_sales ?? 0) - $totalReturns - ($invoice->total_discount ?? 0) + $casherCoinAmount;

                
                // Determine account status
                if ($netBalance == 0) {
                    $status = 'هاوسەنگ';
                    $shortAmount = 0;
                    $extraAmount = 0;
                } elseif ($netBalance < 0) {
                    $status = 'کەم';
                    $shortAmount = abs($netBalance);
                    $extraAmount = 0;
                } else {
                    $status = 'زیاد';
                    $shortAmount = 0;
                    $extraAmount = $netBalance;
                }

                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'cashier_id' => $invoice->user_id,
                    'cashierName' => $invoice->cashier_name,
                    'totalSales' => $invoice->total_sales,
                    'totalReturns' => $totalReturns,
                    'totalDiscount' => $invoice->total_discount,
                    'casherCoin' => $casherCoinAmount,
                    'netReturns' => $netReturns,
                    'todayProfit' => $profit,
                    'accountStatus' => $status,
                    'shortAmount' => $shortAmount,
                    'extraAmount' => $extraAmount,
                    "subtotal"=>$invoice->subtotal,
                    'accountingDate' => $invoice->accountingDate,
                    "casherCoinAmount" => $casherCoinAmount,
                    'date' => $invoice->date,
                    'detailGiven' => $this->getReturnDetails($invoice->user_id, $invoice->accountingDate),
                ];
            });

            return response()->json([
                'success' => true,
                'invoices' => $invoicesWithDetails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading invoices: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single invoice details
     */
    public function show($id)
    {
        try {
            // Get sale info
            $sale = DB::table('sales')
                ->join('users', 'sales.user_id', '=', 'users.id')
                ->where('sales.id', $id)
                ->select(
                    'sales.*',
                    'users.name as cashier_name'
                )
                ->first();

            if (!$sale) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }

            $saleDate = date('Y-m-d', strtotime($sale->created_at));

            // Get sale items
            $items = DB::table('sale_items')
                ->where('sale_id', $id)
                ->select(
                    'id',
                    'product_name as name',
                    'quantity',
                    'purchase_price',
                    'selling_price as price',
                    'total'
                )
                ->get();

            // Get returns for this date
            $returns = DB::table('return_items')
                ->where('Casher_id', $sale->user_id)
                ->whereDate('Return_Date', $saleDate)
                ->select(
                    'Item_Code',
                    'Amount',
                    'Metar',
                    'Sale_Price',
                    'Return_Total',
                    'Return_Cause'
                )
                ->get();

            // Get casher_coin transactions
            $casherCoins = DB::table('casher_coin')
                ->where('casher_id', $sale->user_id)
                ->whereDate('created_at', $saleDate)
                ->select(
                    'id',
                    'amount',
                    'created_at'
                )
                ->get();

            // Calculate profit
            $profit = $this->calculateProfit($id);

            return response()->json([
                'success' => true,
                'invoice' => [
                    'id' => $sale->id,
                    'invoice_number' => $sale->invoice_number,
                    'cashier_name' => $sale->cashier_name,
                    'date' => $sale->created_at,
                    'total_sales' => $sale->total,
                    'total_discount' => $sale->discount,
                    'subtotal' => $sale->subtotal,
                    'total_returns' => $returns->sum('Return_Total'),
                    'casher_coins' => $casherCoins,
                    'casher_coin_total' => $casherCoins->sum('amount'),
                    'profit' => $profit,
                    'items' => $items,
                    'returns' => $returns,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate profit for a sale
     */
    private function calculateProfit($saleId)
    {
        $items = DB::table('sale_items')
            ->where('sale_id', $saleId)
            ->select(
                DB::raw('COALESCE(SUM((selling_price - purchase_price) * quantity), 0) as total_profit')
            )
            ->first();

        return $items->total_profit ?? 0;
    }

    /**
     * Get return details as text
     */
    private function getReturnDetails($cashierId, $date)
    {
        $returns = DB::table('return_items')
            ->where('Casher_id', $cashierId)
            ->whereDate('Return_Date', $date)
            ->select('Return_Cause')
            ->get();

        if ($returns->isEmpty()) {
            return '—';
        }

        return $returns->pluck('Return_Cause')->implode('، ');
    }
}