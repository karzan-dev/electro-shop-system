<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    /**
     * پاشەکەوتکردنی ناوی فرۆشیار لە خشتەی Vouchers
     */
    public function store(Request $request)
    {
        $seller = trim($request->input('voucher_name'));

        if ($seller === '') {
            return response()->json([
                'success' => false,
                'message' => 'تکایە ناوی فرۆشیار بنووسە'
            ], 422);
        }

        $voucher = DB::table('Vouchers')
            ->where('voucher_name', $seller)
            ->first();

        if ($voucher) {
            $id = $voucher->id;
        } else {
            $id = DB::table('Vouchers')->insertGetId([
                'voucher_name' => $seller,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'ناوی فرۆشیار بە سەرکەوتوویی پاشەکەوت کرا',
            'id' => $id,
            'voucher_name' => $seller,
        ]);
    }

    /**
     * وەرگرتنی لیستی هەموو فرۆشیارەکان (سادە)
     */
  public function list(Request $request)
{
    try {
        $query = DB::table('Vouchers as v')
            ->leftJoin('N_Vouchers as nv', 'nv.Voucher_id', '=', 'v.id')
            ->leftJoin('products as p', 'p.id', '=', 'nv.product_id')
            ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
            ->select(
                'v.id',
                'v.voucher_name as name',
                'v.created_at',
                'v.updated_at',
                DB::raw('COUNT(DISTINCT nv.id) as products_count'),
                DB::raw('COUNT(DISTINCT c.id) as companies_count'),
                DB::raw('GROUP_CONCAT(DISTINCT c.company_name ORDER BY c.company_name SEPARATOR "، ") as companies_names')
            )
            ->groupBy('v.id', 'v.voucher_name', 'v.created_at', 'v.updated_at');

        if ($request->filled('search')) {
            $query->where('v.voucher_name', 'like', '%' . $request->search . '%');
        }

        $query->orderBy('v.voucher_name', 'asc');

        if ($request->filled('page') || $request->filled('per_page')) {
            $perPage = $request->get('per_page', 15);
            $sellers = $query->paginate($perPage);

            // 🏢 زیادکردنی لیستی کۆمپانیاکان بۆ هەر فرۆشیارێک
            $sellersItems = collect($sellers->items())->map(function ($seller) {
                $seller->companies = $this->getSellerCompanies($seller->id);
                return $seller;
            });

            return response()->json([
                'success' => true,
                'sellers' => $sellersItems,
                'current_page' => $sellers->currentPage(),
                'last_page' => $sellers->lastPage(),
                'per_page' => $sellers->perPage(),
                'total' => $sellers->total(),
            ]);
        }

        $sellers = $query->get();

        // 🏢 زیادکردنی لیستی کۆمپانیاکان بۆ هەر فرۆشیارێک
        $sellers = $sellers->map(function ($seller) {
            $seller->companies = $this->getSellerCompanies($seller->id);
            return $seller;
        });

        return response()->json([
            'success' => true,
            'sellers' => $sellers,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'هەڵە: ' . $e->getMessage(),
            'sellers' => [],
        ], 500);
    }
}

/**
 * 🏢 وەرگرتنی لیستی کۆمپانیاکان بۆ فرۆشیارێکی دیاریکراو
 */
private function getSellerCompanies($sellerId)
{
    try {
        return DB::table('N_Vouchers as nv')
            ->join('products as p', 'p.id', '=', 'nv.product_id')
            ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
            ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
            ->where('nv.Voucher_id', $sellerId)
            ->select(
                'c.id as company_id',
                DB::raw('COALESCE(c.company_name, "بێ کۆمپانیا") as company_name'),
                DB::raw('COUNT(DISTINCT p.id) as products_count'),
                DB::raw('COALESCE(SUM(pw.counter), 0) as total_stock')
            )
            ->groupBy('c.id', 'c.company_name')
            ->orderBy('c.company_name', 'asc')
            ->get();

    } catch (\Exception $e) {
        return collect([]);
    }
}

    /**
     * وەرگرتنی لیستی فرۆشیارەکان لەگەڵ گەڕان و پەیجینەیشن
     */
    public function listt(Request $request)
    {
        try {
            $query = DB::table('Vouchers as v')
                ->select(
                    'v.id',
                    'v.voucher_name as name',
                    'v.created_at',
                    'v.updated_at',
                    DB::raw('(SELECT COUNT(*) FROM N_Vouchers WHERE Voucher_id = v.id) as products_count')
                );

            if ($request->filled('search')) {
                $query->where('v.voucher_name', 'like', '%' . $request->search . '%');
            }

            $query->orderBy('v.voucher_name', 'asc');

            if ($request->filled('page') || $request->filled('per_page')) {
                $perPage = $request->get('per_page', 15);
                $sellers = $query->paginate($perPage);

                return response()->json([
                    'success' => true,
                    'sellers' => $sellers->items(),
                    'current_page' => $sellers->currentPage(),
                    'last_page' => $sellers->lastPage(),
                    'per_page' => $sellers->perPage(),
                    'total' => $sellers->total(),
                ]);
            }

            $sellers = $query->get();

            return response()->json([
                'success' => true,
                'sellers' => $sellers,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە لە وەرگرتنی لیستا: ' . $e->getMessage(),
                'sellers' => [],
            ], 500);
        }
    }

    /**
     * زیادکردنی فرۆشیاری نوێ
     */
    public function storee(Request $request)
    {
        $request->validate([
            'voucher_name' => 'required|string|max:255|unique:Vouchers,voucher_name',
        ], [
            'voucher_name.required' => 'تکایە ناوی فرۆشیار بنووسە',
            'voucher_name.unique' => 'ئەم ناوە پێشتر تۆمار کراوە',
            'voucher_name.max' => 'ناوەکە زۆر درێژە',
        ]);

        try {
            $id = DB::table('Vouchers')->insertGetId([
                'voucher_name' => trim($request->voucher_name),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'فرۆشیار بە سەرکەوتوویی زیادکرا',
                'seller' => [
                    'id' => $id,
                    'name' => trim($request->voucher_name),
                    'products_count' => 0,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * نوێکردنەوەی ناوی فرۆشیار
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:Vouchers,id',
            'voucher_name' => 'required|string|max:255',
        ], [
            'voucher_name.required' => 'تکایە ناوی فرۆشیار بنووسە',
            'voucher_name.max' => 'ناوەکە زۆر درێژە',
        ]);

        try {
            $exists = DB::table('Vouchers')
                ->where('voucher_name', trim($request->voucher_name))
                ->where('id', '!=', $request->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'ئەم ناوە بۆ فرۆشیارێکی تر بەکارهاتووە',
                ], 422);
            }

            DB::table('Vouchers')
                ->where('id', $request->id)
                ->update([
                    'voucher_name' => trim($request->voucher_name),
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'ناوی فرۆشیار بە سەرکەوتوویی نوێکرایەوە',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * سڕینەوەی فرۆشیار
     */
    public function destroy($id)
    {
        try {
            $seller = DB::table('Vouchers')->where('id', $id)->first();

            if (!$seller) {
                return response()->json([
                    'success' => false,
                    'message' => 'فرۆشیار نەدۆزرایەوە',
                ], 404);
            }

            $productsCount = DB::table('N_Vouchers')->where('Voucher_id', $id)->count();

            if ($productsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "ناتوانرێت بسڕدرێتەوە — ئەم فرۆشیارە بە {$productsCount} کاڵاوە بەستراوەتەوە",
                ], 422);
            }

            DB::table('Vouchers')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'فرۆشیار بە سەرکەوتوویی سڕایەوە',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * لیستی کاڵاکانی فرۆشیار — لەگەڵ وێنە، کۆمپانیا و زانیاری تەواو
     */
    public function products($id)
    {
        try {
            // 1️⃣ پشکنینی فرۆشیار
            $seller = DB::table('Vouchers')->where('id', $id)->first();

            if (!$seller) {
                return response()->json([
                    'success' => false,
                    'message' => 'فرۆشیار نەدۆزرایەوە',
                ], 404);
            }

            // 2️⃣ وەرگرتنی کاڵاکان لەگەڵ وێنە + کۆمپانیا (JOIN)
            $products = DB::table('N_Vouchers as nv')
                ->join('products as p', 'p.id', '=', 'nv.product_id')
                ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
                ->where('nv.Voucher_id', $id)
                ->select(
                    'p.id',
                    'p.barcode',
                    'p.name',
                    'p.company_id',
                    'c.company_name as company',
                    'p.purchase_price',
                    'p.selling_price',
                    'p.minimum_wearhouse',
                    'p.image_product_camera',
                    'p.image_producte_path',
                    'p.in_critical_list',
                    'p.added_to_critical_list_at',
                    'p.critical_list_notes',
                    'p.created_at',
                    'p.updated_at',
                    DB::raw('COALESCE(pw.counter, 0) as counter')
                )
                ->orderBy('p.name', 'asc')
                ->get();

            // 3️⃣ حیساباتی گشتی
            $totalPurchase = 0;
            $totalSelling = 0;
            $totalStock = 0;
            $lowStockCount = 0;
            $outOfStockCount = 0;

            $formattedProducts = $products->map(function ($product) use (
                &$totalPurchase,
                &$totalSelling,
                &$totalStock,
                &$lowStockCount,
                &$outOfStockCount
            ) {
                $stock = (int) $product->counter;
                $purchasePrice = (float) $product->purchase_price;
                $sellingPrice = (float) $product->selling_price;

                $purchaseTotal = $stock * $purchasePrice;
                $sellingTotal = $stock * $sellingPrice;

                $totalPurchase += $purchaseTotal;
                $totalSelling += $sellingTotal;
                $totalStock += $stock;

                $stockStatus = 'normal';
                $stockStatusText = 'بەردەست';

                if ($stock < 0) {
                    $stockStatus = 'negative';
                    $stockStatusText = 'کەمبوونەوە';
                    $outOfStockCount++;
                } elseif ($stock === 0) {
                    $stockStatus = 'out';
                    $stockStatusText = 'تەواو بوو';
                    $outOfStockCount++;
                } elseif ($stock < 3) {
                    $stockStatus = 'critical';
                    $stockStatusText = 'کەمترین';
                    $lowStockCount++;
                } elseif ($stock < 10) {
                    $stockStatus = 'low';
                    $stockStatusText = 'کەم';
                    $lowStockCount++;
                }

                // ✅ چارەسەری وێنە — پشکنینی هەردوو ستوون
                $imageUrl = null;
                if (!empty($product->image_producte_path)) {
                    $imageUrl = asset($product->image_producte_path);
                } elseif (!empty($product->image_product_camera)) {
                    $imageUrl = asset($product->image_product_camera);
                }

                return [
                    'id' => $product->id,
                    'barcode' => $product->barcode,
                    'name' => $product->name,
                    'company_id' => $product->company_id,
                    'company' => $product->company ?? 'بێ کۆمپانیا',
                    'purchase_price' => $purchasePrice,
                    'selling_price' => $sellingPrice,
                    'minimum_wearhouse' => (int) $product->minimum_wearhouse,
                    'counter' => $stock,
                    'stock_status' => $stockStatus,
                    'stock_status_text' => $stockStatusText,
                    'in_critical_list' => (int) $product->in_critical_list,
                    'added_to_critical_list_at' => $product->added_to_critical_list_at,
                    'critical_list_notes' => $product->critical_list_notes,
                    'image_product_camera' => $product->image_product_camera,
                    'image_producte_path' => $product->image_producte_path,
                    'image_url' => $imageUrl,
                    'purchase_total' => $purchaseTotal,
                    'selling_total' => $sellingTotal,
                    'profit' => $sellingTotal - $purchaseTotal,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ];
            });

            // 4️⃣ وەڵام
            return response()->json([
                'success' => true,
                'seller' => [
                    'id' => $seller->id,
                    'name' => $seller->voucher_name,
                    'created_at' => $seller->created_at,
                    'updated_at' => $seller->updated_at,
                ],
                'products' => $formattedProducts,
                'count' => $formattedProducts->count(),
                'statistics' => [
                    'total_products' => $formattedProducts->count(),
                    'total_stock' => $totalStock,
                    'total_purchase' => $totalPurchase,
                    'total_selling' => $totalSelling,
                    'total_profit' => $totalSelling - $totalPurchase,
                    'low_stock_count' => $lowStockCount,
                    'out_of_stock_count' => $outOfStockCount,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
            ], 500);
        }
    }
}