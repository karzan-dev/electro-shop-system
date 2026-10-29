<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductWearhouseController extends Controller
{
    /**
     * لیستی کۆگا — لەگەڵ کۆمپانیا و فرۆشیار
     */
    public function index()
    {
        $stocks = DB::table('product_wearhouse as pw')
            ->join('products as p', 'pw.id_product', '=', 'p.id')
            ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
            ->leftJoin('N_Vouchers as nv', 'nv.product_id', '=', 'p.id')
            ->leftJoin('Vouchers as v', 'v.id', '=', 'nv.Voucher_id')
            ->select(
                'pw.id',
                'pw.id_product',
                'pw.counter',
                'p.name as product_name',
                'p.barcode',
                'p.purchase_price',
                'p.selling_price',
                'p.company_id',
                DB::raw('COALESCE(c.company_name, "بێ کۆمپانیا") as company_name'),
                'v.voucher_name'
            )
            ->get();

        return view('product_wearhouse.index', compact('stocks'));
    }

    /**
     * زیادکردن یان نوێکردنەوەی کۆگا
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'barcode' => 'required',
                'purchase_price' => 'required|numeric',
                'selling_price' => 'required|numeric',
                'current_stock' => 'required|numeric',
            ]);

            // 📦 پڕۆداکت لە products table بدۆزەوە
            $product = DB::table('products')
                ->where('barcode', $request->barcode)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'کاڵا نەدۆزرایەوە'
                ], 404);
            }

            // 🔍 دڵنیابە ئەگەر پێشتر هەیە لە warehouse
            $existing = DB::table('product_wearhouse')
                ->where('id_product', $product->id)
                ->first();

            if ($existing) {
                // ✅ ئەگەر هەیە → counter نوێ بکەرەوە
                DB::table('product_wearhouse')
                    ->where('id_product', $product->id)
                    ->update([
                        'counter' => $request->current_stock
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'کۆگا نوێکرایەوە',
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'barcode' => $product->barcode,
                    ]
                ]);
            } else {
                // 🆕 insert نوێ
                DB::table('product_wearhouse')->insert([
                    'id_product' => $product->id,
                    'counter'     => $request->current_stock,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'کاڵا زیادکرا بۆ کۆگا',
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'barcode' => $product->barcode,
                    ]
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * نوێکردنەوەی کۆگا
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'current_stock' => 'required|numeric',
            ]);

            // 🔍 پشکنین ئەگەر ڕیزەکە هەیە
            $warehouse = DB::table('product_wearhouse')->where('id', $id)->first();

            if (!$warehouse) {
                return response()->json([
                    'success' => false,
                    'message' => 'کۆگا نەدۆزرایەوە'
                ], 404);
            }

            // ✅ تەنها counter نوێ بکەرەوە
            DB::table('product_wearhouse')
                ->where('id', $id)
                ->update([
                    'counter' => $request->current_stock,
                ]);

            return response()->json([
                'success' => true,
                'message' => 'کۆگا نوێکرایەوە'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * سڕینەوەی کۆگا
     */
    public function destroy($id)
    {
        try {
            $warehouse = DB::table('product_wearhouse')->where('id', $id)->first();

            if (!$warehouse) {
                return response()->json([
                    'success' => false,
                    'message' => 'کۆگا نەدۆزرایەوە'
                ], 404);
            }

            DB::table('product_wearhouse')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'کۆگا سڕایەوە'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🏢 گەڕان بەپێی کۆمپانیا
     */
    public function byCompany(Request $request)
    {
        try {
            $query = DB::table('product_wearhouse as pw')
                ->join('products as p', 'pw.id_product', '=', 'p.id')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
                ->select(
                    'pw.id',
                    'pw.id_product',
                    'pw.counter',
                    'p.name as product_name',
                    'p.barcode',
                    'p.purchase_price',
                    'p.selling_price',
                    'p.company_id',
                    DB::raw('COALESCE(c.company_name, "بێ کۆمپانیا") as company_name')
                );

            // 🏢 فلتەر بەپێی کۆمپانیا
            if ($request->filled('company_id')) {
                $query->where('p.company_id', $request->company_id);
            }

            // 🔍 گەڕان بەپێی ناو
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('p.name', 'like', "%{$search}%")
                      ->orWhere('p.barcode', 'like', "%{$search}%")
                      ->orWhere('c.company_name', 'like', "%{$search}%");
                });
            }

            $stocks = $query->orderBy('p.name', 'asc')->get();

            // 🏢 ئاماری کۆمپانیاکان
            $companiesStats = DB::table('product_wearhouse as pw')
                ->join('products as p', 'pw.id_product', '=', 'p.id')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
                ->select(
                    DB::raw('COALESCE(c.company_name, "بێ کۆمپانیا") as company_name'),
                    'p.company_id',
                    DB::raw('COUNT(DISTINCT p.id) as products_count'),
                    DB::raw('SUM(pw.counter) as total_stock')
                )
                ->groupBy('p.company_id', 'c.company_name')
                ->get();

            return response()->json([
                'success' => true,
                'stocks' => $stocks,
                'count' => $stocks->count(),
                'companies' => $companiesStats,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
                'stocks' => [],
            ], 500);
        }
    }
}