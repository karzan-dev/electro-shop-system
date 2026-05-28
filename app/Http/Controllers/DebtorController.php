<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Debtor;
use  Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
class DebtorController extends Controller
{
    public function debtors_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string|max:255',
            'products.*.company' => 'required|string|max:255',
            'products.*.selling_price' => 'required|numeric|min:0',
            'products.*.total_selling' => 'required|numeric|min:0',
            'credit_date' => 'required|date',
            'advance_payment' => 'nullable|numeric|min:0',
            'repayment_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create or update customer
            $customer = DB::table('customer')
                ->where('number_phone', $request->customer_phone)
                ->first();

            if ($customer) {
                DB::table('customer')
                    ->where('id', $customer->id)
                    ->update([
                        'name' => $request->customer_name,
                        'address' => $request->customer_address ?? $customer->address,
                    ]);
                $customer_id = $customer->id;
            } else {
                $customer_id = DB::table('customer')->insertGetId([
                    'name' => $request->customer_name,
                    'number_phone' => $request->customer_phone,
                    'address' => $request->customer_address ?? 'نادیار',
                ]);
            }

            // Calculate period
            $startDate = new \DateTime($request->credit_date);
            $endDate = new \DateTime($request->repayment_date);
            $period = $startDate->diff($endDate)->days;

            $advance = $request->advance_payment ?? 0;
            
            // Generate invoice number (you might want to customize this)
            $invoice_number = 000000;

            foreach ($request->products as $index => $product) {
                // Check if private good exists
                $existingProduct = DB::table('private_goods')
                    ->where('name', $product['name'])
                    ->first();

                if (!$existingProduct) {
                    $private_goods_id = DB::table('private_goods')->insertGetId([
                        'name' => $product['name'],
                        'company' => $product['company'],
                    ]);
                } else {
                    $private_goods_id = $existingProduct->id;
                }
                 $selling = $product['selling_price'];

    // share of remaining (if needed per product)
               $money_left = $selling - ($advance / count($request->products));

                // Insert into loans table with all columns
                DB::table('loans')->insert([
                    'sels_id' =>0, // Sequential number for each product
                    'invoice_number' => $invoice_number,
                    'private_goods_id' => $private_goods_id,
                    'customer_id' => $customer_id,
                    'currency' => $request->advance_payment, // Default currency, you can make this dynamic
                    'period' => $money_left,
                    'total' => $product['selling_price'],
                    'status' => 2, // Default status for new loans
                    'time_to_return' => $request->repayment_date,
                    'created_at' => $request->credit_date,
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'قەرز بە سەرکەوتوویی تۆمار کرا',
                'invoice_number' => $invoice_number
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Process payment for a debtor
     */
 /**
     * Process payment for a debtor
     */
public function pay(Request $request)
{
    $validator = Validator::make($request->all(), [
        'debtor_id' => 'required|exists:loans,id',
        'amount' => 'required|numeric|min:0',
        'payment_type' => 'required|in:now,later',
        'later_date' => 'nullable|required_if:payment_type,later|date|after:today',

    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    DB::beginTransaction();

   


    try {
        $loanId = $request->debtor_id;
        

        
        // 1. First, try a simple update to test if DB works
        $testUpdate = DB::table('loans')
            ->where('id', $loanId)
            ->update([
                'updated_at' => now(),
            ]);
        
        // Log the test result
        Log::info('Test update result: ' . $testUpdate);
        
        if (!$testUpdate) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'ناتوانرێت قەرزەکە نوێ بکرێتەوە - ID: ' . $loanId,
            ], 500);
        }

        // 2. Get the loan
        $loan = DB::table('loans')->where('id', $loanId)->first();
        
        if (!$loan) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'قەرز نەدۆزرایەوە',
            ], 404);
        }

        // 3. Calculate total paid
        $totalPaid = DB::table('installments')
            ->where('loan_id', $loanId)
            ->sum('pyment_of_mony');

        if ($request->payment_type === 'now') {
            $amount = $request->amount;
            $remainingBefore = $loan->period - $totalPaid;
            
            // Check if amount is valid
            if ($amount > $loan->period && $remainingBefore > 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'بڕی پارەدان زیاترە لە قەرزی ماوە',
                ], 422);
            }

            // Insert installment
            $installmentId = DB::table('installments')->insertGetId([
                'loan_id' => $loanId,
                'users_id' => Auth::id() ?? 1,
                'pyment_of_mony' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Calculate new values
            $newTotalPaid = $totalPaid + $amount;
            $newRemaining = $loan->period - $newTotalPaid;
            
            // Build update array
            $updateData = [
                'currency' => $loan->currency + $amount,
                'period' =>$loan->total - ($amount + $loan->currency),
                'updated_at' => now(),
            ];
            
            // Set status
            if ($newRemaining <= 0) {
                $updateData['status'] = 2;
            } elseif ($loan->status === 'overdue') {
                $updateData['status'] = 1;
            }
            
            // DIRECT UPDATE - Using Query Builder
            $affected = DB::table('loans')
                ->where('id', $loanId)
                ->update($updateData);
            
            Log::info('Payment update:', [
                'loan_id' => $loanId,
                'update_data' => $updateData,
                'affected_rows' => $affected
            ]);

            if (!$affected) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'نوێکردنەوەی قەرز سەرکەوتوو نەبوو',
                    'debug' => $updateData
                ], 500);
            }

        } else {
            // Later payment
            $amount = $request->amount ?? 0;
            
            $installmentId = DB::table('installments')->insertGetId([
                'loan_id' => $loanId,
                'users_id' => Auth::id() ?? 1,
                'pyment_of_mony' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $updateData = ['updated_at' => now()];
            
         
            
           
            $affected = DB::table('loans')
                ->where('id', $loanId)
                ->update([
                    "time_to_return" => $request->later_date,
                    "status" => 2,
                    "currency" => $amount+$loan->currency,
                    "period" => $loan->total - ($amount + $loan->currency),
                    "updated_at" => now(),

                ]);
                
            Log::info('Later payment update:', [
                'loan_id' => $loanId,
                'update_data' => $updateData,
                'affected_rows' => $affected
            ]);
        }

        // Get fresh data
        $updatedLoan = DB::table('loans')->where('id', $loanId)->first();
        $installment = DB::table('installments')->where('id', $installmentId)->first();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => $request->payment_type === 'now' 
                ? 'پارەدان بە سەرکەوتوویی تۆمارکرا' 
                : 'بەڵێنی پارەدان تۆمارکرا',
            'loan' => $updatedLoan,
            'installment' => $installment,
            "request_data" => $request->all()
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        
        Log::error('Payment error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage(),
        ], 500);
    }
}
    /**
     * Delete a loan record and its installments
     */
   


    /**
     * Remove the specified debtor (loan) and all related records.
     */
  public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            // Find the loan/debtor
            $loan = DB::table('loans')->where('id', $id)->first();
            
            if (!$loan) {
                return response()->json([
                    'success' => false,
                    'message' => 'قەرزار نەدۆزرایەوە'
                ], 404);
            }
            
            // Delete related installments
            DB::table('installments')->where('loan_id', $id)->delete();
            
            // Delete sale items and sale if exists
          
            // Delete the loan record
            DB::table('loans')->where('id', $id)->delete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'قەرز و هەموو تۆمارە پەیوەندیدارەکان بە سەرکەوتوویی سڕانەوە'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا لە سڕینەوەی قەرز: ' . $e->getMessage()
            ], 500);
        }
    }


    public function paymentHistory(Request $request)
{
    $debtorId = $request->debtor_id;
    
    // Fetch installments/payments for this debtor
    // Adjust the query based on your database structure
    $payments = DB::table('installments')
        ->where('loan_id', $debtorId) // Adjust field name based on your schema
        ->orderBy('created_at', 'desc')
        ->get();
    
    return response()->json([
        'success' => true,
        'payments' => $payments
    ]);
}
}


