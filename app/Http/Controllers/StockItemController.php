<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\StockItem;
use Illuminate\Support\Facades\Log;

class StockItemController extends Controller
{


public function store(Request $request)
{
    try {
        // Log the incoming request for debugging
        Log::info('Stock store request:', $request->all());

        // Validate input
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'amount' => 'required|integer|min:1',
            'stock_reason' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Trim input data
        $product_id = intval($request->product_id);
        $amount = intval($request->amount);
        $stock_reason = trim($request->stock_reason);
        $notes = $request->notes ?: '';

        // Find product by barcode
        $product = DB::table('products')->where('id', $product_id)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'کاڵا نەدۆزرایەوە لە داتابەیس'
            ], 404);
        }

        // Check if stock_item table exists and has correct columns
        try {
            DB::table('stock_item')->insert([
                'products_id' => $product->id,
                'Amount' => $amount,
                'Stock_Couse' => $stock_reason,
                'Note' => $notes,
                'Entry_Date' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('Stock item insert failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵە لە تۆمارکردنی ستۆک: ' . $e->getMessage()
            ], 500);
        }

        // Update warehouse counter
        try {
            $warehouse = DB::table('product_wearhouse')
                ->where('id_product', $product->id)
                ->first();

            if ($warehouse) {
                DB::table('product_wearhouse')
                    ->where('id_product', $product->id)
                    ->decrement('counter', $amount);
                DB::table('products')
                    ->where('id', $product->id)
                    ->decrement('minimum_wearhouse', $amount);
                  
            } else {
                DB::table('product_wearhouse')->insert([
                    'id_product' => $product->id,
                    'counter' => 0 - $amount,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Warehouse update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵە لە نوێکردنەوەی کۆگا: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'داتاکە سەرکەوتووانە نێردرا بۆ داتابەیس و counter کەمکرا'
        ]);

    } catch (\Exception $e) {
        Log::error('Stock store general error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'هەڵەی گشتی: ' . $e->getMessage()
        ], 500);
    }
}




    /**
     * Search products by name for autocomplete
     */
}
