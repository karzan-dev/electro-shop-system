<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
}