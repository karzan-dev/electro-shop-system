<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CompanyDebtController extends Controller
{
    /**
     * Display the company debts page
     */
    public function index()
    {
        return view('items.company_debts');
    }

    /**
     * Get list of all company debts with stats
     */
    public function list(Request $request)
    {
        try {
            $query = DB::table('company_debts');
            
            // Search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('company_name', 'like', '%' . $search . '%');
            }

            // Get all debts
            $debts = $query->orderBy('created_at', 'desc')->get();

            // Calculate stats
            $totalDebt = $debts->sum('debt_amount');
            $totalPaid = DB::table('company_debt_payments')->sum('amount') ?? 0;
            $totalRemaining = $totalDebt - $totalPaid;
            $companiesCount = $debts->pluck('company_name')->unique()->count();

            return response()->json([
                'success' => true,
                'data' => $debts,
                'stats' => [
                    'total_debt' => $totalDebt,
                    'total_paid' => $totalPaid,
                    'total_remaining' => $totalRemaining,
                    'companies_count' => $companiesCount,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('CompanyDebt list error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا لە بارکردنی زانیارییەکان'
            ], 500);
        }
    }

    /**
     * Store a new company debt
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'debt_amount' => 'required|numeric|min:1|max:999999999.99',
            'debt_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:debt_date',
            'note' => 'nullable|string|max:1000',
        ], [
            'company_name.required' => 'ناوی کۆمپانیا پێویستە',
            'company_name.max' => 'ناوی کۆمپانیا زۆر درێژە',
            'debt_amount.required' => 'بڕی قەرز پێویستە',
            'debt_amount.numeric' => 'بڕی قەرز دەبێت ژمارە بێت',
            'debt_amount.min' => 'بڕی قەرز دەبێت لە ١ زیاتر بێت',
            'debt_amount.max' => 'بڕی قەرز زۆر گەورەیە',
            'debt_date.required' => 'بەرواری قەرز پێویستە',
            'debt_date.date' => 'بەرواری قەرز نادروستە',
            'due_date.after_or_equal' => 'بەرواری کۆتایی دەبێت دوای یان هاوشانی بەرواری قەرز بێت',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            DB::table('company_debts')->insert([
                'company_name' => $request->company_name,
                'debt_amount' => $request->debt_amount,
                'total_paid' => 0,
                'debt_date' => $request->debt_date,
                'due_date' => $request->due_date,
                'note' => $request->note,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'قەرز بە سەرکەوتوویی تۆمارکرا'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CompanyDebt store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا، تکایە دووبارە هەوڵبدەوە'
            ], 500);
        }
    }

    /**
     * Update an existing company debt
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'debt_amount' => 'required|numeric|min:1|max:999999999.99',
            'debt_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:debt_date',
            'note' => 'nullable|string|max:1000',
        ], [
            'company_name.required' => 'ناوی کۆمپانیا پێویستە',
            'debt_amount.required' => 'بڕی قەرز پێویستە',
            'debt_amount.numeric' => 'بڕی قەرز دەبێت ژمارە بێت',
            'debt_amount.min' => 'بڕی قەرز دەبێت لە ١ زیاتر بێت',
            'debt_date.required' => 'بەرواری قەرز پێویستە',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Check if debt exists
            $debt = DB::table('company_debts')->where('id', $id)->first();
            if (!$debt) {
                return response()->json([
                    'success' => false,
                    'message' => 'قەرز نەدۆزرایەوە'
                ], 404);
            }

            // Check if new debt amount is less than total paid
            if ($request->debt_amount < $debt->total_paid) {
                return response()->json([
                    'success' => false,
                    'message' => 'بڕی قەرزی نوێ ناتوانێت کەمتر بێت لە پارەی دراو'
                ], 422);
            }

            DB::table('company_debts')->where('id', $id)->update([
                'company_name' => $request->company_name,
                'debt_amount' => $request->debt_amount,
                'debt_date' => $request->debt_date,
                'due_date' => $request->due_date,
                'note' => $request->note,
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'قەرز بە سەرکەوتوویی نوێکرایەوە'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CompanyDebt update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا، تکایە دووبارە هەوڵبدەوە'
            ], 500);
        }
    }

    /**
     * Delete a company debt and its payments
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Check if debt exists
            $debt = DB::table('company_debts')->where('id', $id)->first();
            if (!$debt) {
                return response()->json([
                    'success' => false,
                    'message' => 'قەرز نەدۆزرایەوە'
                ], 404);
            }

            // Delete related payments first
            DB::table('company_debt_payments')->where('debt_id', $id)->delete();
            
            // Delete the debt
            DB::table('company_debts')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'قەرز بە سەرکەوتوویی سڕایەوە'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CompanyDebt destroy error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا، تکایە دووبارە هەوڵبدەوە'
            ], 500);
        }
    }

    /**
     * Add a payment to a company debt
     */
    public function addPayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:999999999.99',
            'payment_date' => 'required|date',
            'note' => 'nullable|string|max:500',
        ], [
            'amount.required' => 'بڕی پارەدان پێویستە',
            'amount.numeric' => 'بڕی پارەدان دەبێت ژمارە بێت',
            'amount.min' => 'بڕی پارەدان دەبێت لە ١ زیاتر بێت',
            'payment_date.required' => 'بەرواری پارەدان پێویستە',
            'payment_date.date' => 'بەرواری پارەدان نادروستە',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Check if debt exists
            $debt = DB::table('company_debts')->where('id', $id)->first();
            if (!$debt) {
                return response()->json([
                    'success' => false,
                    'message' => 'قەرز نەدۆزرایەوە'
                ], 404);
            }

            // Check if payment amount exceeds remaining debt
            $remaining = $debt->debt_amount - $debt->total_paid;
            if ($request->amount > $remaining) {
                return response()->json([
                    'success' => false,
                    'message' => 'بڕی پارەدان (' . number_format($request->amount) . ') زیاترە لە قەرزی ماوە (' . number_format($remaining) . ')'
                ], 422);
            }

            // Insert payment record
            DB::table('company_debt_payments')->insert([
                'debt_id' => $id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'note' => $request->note,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update total_paid in debt record
            DB::table('company_debts')->where('id', $id)->update([
                'total_paid' => $debt->total_paid + $request->amount,
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'پارەدان بە سەرکەوتوویی تۆمارکرا'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CompanyDebt addPayment error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا، تکایە دووبارە هەوڵبدەوە'
            ], 500);
        }
    }

    /**
     * Get payment history for a specific debt
     */
    public function paymentHistory($id)
    {
        try {
            $debt = DB::table('company_debts')->where('id', $id)->first();
            if (!$debt) {
                return response()->json([
                    'success' => false,
                    'message' => 'قەرز نەدۆزرایەوە'
                ], 404);
            }

            $payments = DB::table('company_debt_payments')
                ->where('debt_id', $id)
                ->orderBy('payment_date', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'debt' => $debt,
                'payments' => $payments
            ]);
        } catch (\Exception $e) {
            Log::error('CompanyDebt paymentHistory error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا'
            ], 500);
        }
    }
}