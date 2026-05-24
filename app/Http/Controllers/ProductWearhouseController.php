<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductWearhouseController extends Controller
{


public function index()
{
    $stocks = DB::table('product_wearhouse')
        ->join('products', 'product_wearhouse.id_product', '=', 'products.id')
        ->select(
            'product_wearhouse.*',
            'products.name as product_name'
        )
        ->get();

    return view('product_wearhouse.index', compact('stocks'));
}

    // Show all stock items
public function store(Request $request)
{
    try {
        $request->validate([
            'barcode' => 'required',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'current_stock' => 'required|numeric',
        ]);

        // پڕۆداکت لە products table بدۆزەوە
        $product = DB::table('products')
            ->where('barcode', $request->barcode)
            ->first();

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // دڵنیابە ئەگەر پێشتر هەیە لە warehouse
        $existing = DB::table('product_wearhouse')
            ->where('id_product', $product->id)
            ->first();

        if ($existing) {
            // ئەگەر هەیە → counter نوێ بکەیت
            DB::table('product_wearhouse')
                ->where('id_product', $product->id)
                ->update([
                    'counter' => $request->current_stock
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Product stock updated successfully'
            ]);
        } else {
            // insert نوێ بکە
            DB::table('product_wearhouse')->insert([
                'id_product' => $product->id,
                'counter'     => $request->current_stock,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product added to warehouse successfully'
            ]);
        }

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}







    // Update a stock item
    public function update(Request $request, $id)
    {
        DB::table('product_wearhouse')
            ->where('id', $id)
            ->update([
                'amount' => $request->amount,
                'buy_price' => $request->buy_price,
                'sell_price' => $request->sell_price,
                'updated_at' => now()
            ]);

        return response()->json(['success' => true]);
    }
}
