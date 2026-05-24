<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReturnItemController extends Controller
{
    /**
     * Display the returns page
     */
    public function index()
    {
        $currentDollarRate = 1450; // You can get this from settings table if you have one

        return view('returns.index', compact('currentDollarRate'));
    }




    /**
     * Search product by barcode for returns
     */
    public function searchByBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string'
        ]);

        try {
            $product = DB::table('products')
                ->where('barcode', $request->barcode)
                ->select(
                    'id',
                    'name',
                    'barcode',
                    'company',
                    'purchase_price',
                    'selling_price',
                    'minimum_wearhouse as counter',
                    'image_producte_path'
                )
                ->first();

            if ($product) {
                // Check if product was recently sold (optional - for return validation)
                $recentlySold = DB::table('sale_items')
                    ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                    ->where('sale_items.product_id', $product->id)
                    ->where('sales.created_at', '>=', now()->subDays(30))
                    ->exists();

                return response()->json([
                    'success' => true,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'barcode' => $product->barcode,
                        'company' => $product->company,
                        'purchase_price' => $product->purchase_price,
                        'selling_price' => $product->selling_price,
                        'counter' => $product->counter ?? 0,
                        'image_producte_path' => $product->image_producte_path
                    ],
                    'recently_sold' => $recentlySold
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'کاڵا نەدۆزرایەوە'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search products by name for returns
     */

    // ... methods before ...

    /**
     * Search products by name for returns
     * بەکارهێنانی products, sales, sale_items
     */
public function searchByName(Request $request)
{
    $request->validate([
        'name' => 'required|string|min:2'
    ]);

    try {
        // گەڕان بۆ کاڵا لە خشتەی products
        $products = DB::table('products')
            ->where('name', 'LIKE', '%' . $request->name . '%')
            ->orWhere('barcode', 'LIKE', '%' . $request->name . '%')
            ->orWhere('company', 'LIKE', '%' . $request->name . '%')
            ->select(
                'id',
                'name',
                'barcode',
                'company',
                'selling_price',
                'purchase_price',
                'minimum_wearhouse as counter',
                'image_producte_path'
            )
            ->orderBy('name')
            ->limit(10)
            ->get();

        if ($products->isNotEmpty()) {
            $formattedProducts = $products->map(function($product) {
                // ڕاستکردنەوەی ڕێڕەوی وێنە
                $imagePath = null;
                if ($product->image_producte_path) {
                    if (strpos($product->image_producte_path, 'storage/') === 0) {
                        $imagePath = asset($product->image_producte_path);
                    } elseif (filter_var($product->image_producte_path, FILTER_VALIDATE_URL)) {
                        $imagePath = $product->image_producte_path;
                    } elseif (strpos($product->image_producte_path, 'images/') === 0) {
                        $imagePath = asset($product->image_producte_path);
                    } else {
                        $imagePath = asset('storage/products/' . ltrim($product->image_producte_path, '/'));
                    }
                }

                // پشکنین بۆ ئەوەی بزانین ئایا ئەم کاڵایە فرۆشراوە یان نا
                $saleItemsCount = DB::table('sale_items')
                    ->where('product_id', $product->id)
                    ->where('product_name', $product->name)
                    ->count();

                $hasBeenSold = $saleItemsCount > 0;

                // ئەگەر نەفرۆشراوە، زانیاری فرۆشراو دەکەینە null
                if (!$hasBeenSold) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'barcode' => $product->barcode,
                        'company' => $product->company,
                        'selling_price' => $product->selling_price,
                        'purchase_price' => $product->purchase_price,
                        'counter' => $product->counter ?? 0,
                        'image_producte_path' => $imagePath,
                        'has_been_sold' => false,
                        'message' => 'ئەم کاڵایە نەفرۆشراوە',
                        'status_color' => 'warning',
                        'sales_info' => null
                    ];
                }

                // وەرگرتنی کۆی فرۆشراو لە sale_items
                $totalSold = DB::table('sale_items')
                    ->where('product_id', $product->id)
                    ->where('product_name', $product->name)
                    ->sum('quantity');

                // وەرگرتنی دوایین فرۆشراو لە sale_items
                $lastSale = DB::table('sale_items')
                    ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                    ->where('sale_items.product_id', $product->id)
                    ->where('sale_items.product_name', $product->name)
                    ->select(
                        'sales.invoice_number',
                        'sales.subtotal',
                        'sales.discount',
                        'sales.total as sale_total',
                        'sale_items.selling_price',
                        'sale_items.quantity',
                        'sale_items.total as item_total',
                        'sale_items.created_at'
                    )
                    ->orderBy('sale_items.created_at', 'desc')
                    ->first();

                // کۆی گشتی فرۆشراو بە دینار
                $totalSalesAmount = DB::table('sale_items')
                    ->where('product_id', $product->id)
                    ->where('product_name', $product->name)
                    ->sum('total');

                // ژمارەی جاری فرۆشراو
                $salesCount = DB::table('sale_items')
                    ->where('product_id', $product->id)
                    ->where('product_name', $product->name)
                    ->count('sale_id');

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'barcode' => $product->barcode,
                    'company' => $product->company,
                    'selling_price' => $product->selling_price,
                    'purchase_price' => $product->purchase_price,
                    'counter' => $product->counter ?? 0,
                    'image_producte_path' => $imagePath,
                    'has_been_sold' => true,
                    'status_color' => 'success',
                    'sales_info' => [
                        'total_sold' => $totalSold,
                        'total_sales_amount' => $totalSalesAmount,
                        'sales_count' => $salesCount,
                        'last_sale' => $lastSale ? [
                            'invoice' => $lastSale->invoice_number,
                            'date' => $lastSale->created_at,
                            'quantity' => $lastSale->quantity,
                            'price' => $lastSale->selling_price,
                            'total' => $lastSale->item_total
                        ] : null
                    ]
                ];
            });

            // ئاماری گشتی بۆ گەڕانەکە
            $totalProductsFound = $products->count();
            $soldProducts = collect($formattedProducts)->where('has_been_sold', true);
            $unsoldProducts = collect($formattedProducts)->where('has_been_sold', false);

            return response()->json([
                'success' => true,
                'products' => $formattedProducts,
                'summary' => [
                    'total_products' => $totalProductsFound,
                    'sold_products' => $soldProducts->count(),
                    'unsold_products' => $unsoldProducts->count()
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'هیچ کاڵایەک نەدۆزرایەوە'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
        ], 500);
    }
}


/**
 * Search for products by invoice number
 * بەدوای کاڵادا گەڕان بە ژمارەی پسوڵە
 */
/**
 * Search for products by invoice number
 * بەدوای کاڵادا گەڕان بە ژمارەی پسوڵە
 */
public function searchByInvoice(Request $request)
{
    try {
        $invoiceNumber = $request->input('invoice_number');

        if (empty($invoiceNumber)) {
            return response()->json([
                'success' => false,
                'message' => 'تکایە ژمارەی پسوڵە بنووسە'
            ]);
        }

        // 1️⃣ گەڕان لە loans بۆ بینینی ئەم پسوڵەیە قەرزە یان نا
       // 1️⃣ گەڕان لە loans بۆ بینینی ئەم پسوڵەیە قەرزە یان نا (partial match)
$loan = DB::table('loans')
    ->where('invoice_number', 'LIKE', '%' . $invoiceNumber . '%')
    ->where('status', 2) // فقط قەرزەکان
    ->first();

        $isCredit = $loan ? true : false;

        $loanData = null;
        if ($loan) {
            $loanData = [
                'loan_id' => $loan->id,
                'sels_id' => $loan->sels_id,
                'invoice_number' => $loan->invoice_number,
                'customer_name' => $loan->name,
                'phone_number' => $loan->phone_number,
                'address' => $loan->address,
                'currency' => $loan->currency,
                'period' => $loan->period,
                'total' => $loan->total,
                'status' => $loan->status,
                'time_to_return' => $loan->time_to_return,
                'created_at' => $loan->created_at,
                'formatted_total' => number_format($loan->total),
                'status_text' => 'قەرز'
            ];
        }

        // 2️⃣ گەڕان لە sales بۆ دۆزینەوەی پسوڵە
        $sales = DB::table('sales')
            ->where('invoice_number', 'LIKE', '%' . $invoiceNumber . '%')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if ($sales->isEmpty() && !$isCredit) {
            return response()->json([
                'success' => false,
                'message' => 'هیچ پسوڵەیەک نەدۆزرایەوە'
            ]);
        }

        // 3️⃣ وەرگرتنی هەموو sale_items و details
        $saleIds = $sales->pluck('id')->toArray();

        $allItems = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereIn('sale_items.sale_id', $saleIds)
            ->select(
                'sale_items.*',
                'sale_items.sale_id',
                'products.name as product_name',
                'products.barcode',
                'products.image_producte_path',
                'products.minimum_wearhouse as current_stock'
            )
            ->get()
            ->groupBy('sale_id');

        $results = [];

        foreach ($sales as $sale) {
            $items = isset($allItems[$sale->id]) ? $allItems[$sale->id] : collect([]);

            $itemsData = $items->map(function($item) {
                return [
                    'id' => $item->product_id,
                    'name' => $item->product_name,
                    'barcode' => $item->barcode,
                    'quantity_sold' => $item->quantity,
                    'selling_price' => $item->selling_price,
                    'purchase_price' => $item->purchase_price ?? 0,
                    'total' => $item->total,
                    'current_stock' => $item->current_stock ?? 0,
                    'image_producte_path' => $this->formatImagePath($item->image_producte_path)
                ];
            })->toArray();

            // 4️⃣ چیک کردن sale یەکە ئایا قەرزە یان نا
            $isThisSaleCredit = ($loan && $loan->invoice_number == $sale->invoice_number);

            $results[] = [
                'sale_id' => $sale->id,
                'invoice_number' => $sale->invoice_number,
                'subtotal' => $sale->subtotal,
                'discount' => $sale->discount,
                'total' => $sale->total,
                'created_at' => $sale->created_at,
                'items' => $itemsData,
                'items_count' => count($itemsData),
                'is_credit' => $isThisSaleCredit,
                'credit_info' => $isThisSaleCredit ? $loanData : null,
                'formatted' => [
                    'subtotal' => number_format($sale->subtotal),
                    'discount' => number_format($sale->discount),
                    'total' => number_format($sale->total)
                ]
            ];
        }

        // 5️⃣ نهایی response
        return response()->json([
            'success' => true,
            'sales' => $results,
            'count' => count($results),
            'has_credit' => $isCredit,
            'credit_summary' => $loanData,
            'loan_exists' => $loan ? true : false,
            'searched_invoice' => $invoiceNumber
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
        ], 500);
    }
}
/**
 * Format image path helper
 */
private function formatImagePath($path)
{
    if (!$path) {
        return null;
    }

    if (strpos($path, 'storage/') === 0) {
        return asset($path);
    } elseif (filter_var($path, FILTER_VALIDATE_URL)) {
        return $path;
    } elseif (strpos($path, 'images/') === 0) {
        return asset($path);
    } else {
        return asset('storage/products/' . ltrim($path, '/'));
    }
}



public function store(Request $request)
{
    try {
        DB::beginTransaction();

        $items = $request->items;

        if (empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'هیچ کاڵایەک نیە'
            ], 422);
        }

        $returnTotal = 0;
        $casherId = Auth::id();

        foreach ($items as $item) {
              $requestss = $request->all();
        $itemss = DB::table("sale_items")
    ->where("id", $requestss['items'][0]['item_id'])
    ->get(); // چونکە get() array دەگەڕێنێت

$product_id = $itemss[0]->product_id;

            $itemTotal = $item['quantity'] * $item['price'];
            $returnTotal += $itemTotal;

            DB::table('return_items')->insert([
                'Item_Code' => $product_id,
                'Amount' => $item['quantity'],
                'Metar' => $request->return_reason ?? null,
                'Sale_Price' => $item['price'],
                'Return_Total' => $itemTotal,
                'Return_Cause' => $request->return_reason,
                'Casher_id' => $casherId,
                'Return_Date' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

       


            DB::table('product_wearhouse')
                ->where('id_product', $product_id)
                ->increment('counter', $item['quantity']);

            DB::table('sale_items')
                ->where('id', $item['item_id'])
                ->delete();
        }

        // ✅ UPDATE total
        DB::table('sales')
            ->where('id', $request->invoice_id)
            ->decrement('total', $returnTotal);

        // ✅ CHECK total
        $sale = DB::table('sales')
            ->where('id', $request->invoice_id)
            ->first();

        if ($sale && $sale->total <= 0) {

            // 🔥 DELETE sale_items if any left
            DB::table('sale_items')
                ->where('sale_id', $sale->id)
                ->delete();

            // 🔥 DELETE loans (ئەگەر قەرز بوو)
          
            // 🔥 DELETE sales
            DB::table('sales')
                ->where('id', $sale->id)
                ->delete();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'سەرکەوتوو',
            'return_total' => $returnTotal
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}


public function processReturn(Request $request)
{
   
    try {
        DB::beginTransaction();

        $items = $request->items;

        if (empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'هیچ کاڵایەک نیە'
            ], 422);
        }

        $returnTotal = 0;
        $casherId = Auth::id();

        foreach ($items as $item) {

            $itemTotal = $item['quantity'] * $item['price'];
            $returnTotal += $itemTotal;

            DB::table('return_items')->insert([
                'Item_Code' => $item['item_id'],
                'Amount' => $item['quantity'],
                'Metar' => $request->return_reason ?? null,
                'Sale_Price' => $item['price'],
                'Return_Total' => $itemTotal,
                'Return_Cause' => $request->return_reason,
                'Casher_id' => $casherId,
                'Return_Date' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

         $requestss = $request->all();
        $itemss = DB::table("sale_items")
    ->where("id", $requestss['items'][0]['item_id'])
    ->get(); // چونکە get() array دەگەڕێنێت

$product_id = $itemss[0]->product_id;


            DB::table('product_wearhouse')
                ->where('id_product', $product_id)
                ->increment('counter', $item['quantity']);

            DB::table('sale_items')
                ->where('id', $item['item_id'])
                ->delete();
        }

        // ✅ UPDATE total
        DB::table('sales')
            ->where('id', $request->invoice_id)
            ->decrement('total', $returnTotal);

        // ✅ CHECK total
        $sale = DB::table('sales')
            ->where('id', $request->invoice_id)
            ->first();

        if ($sale && $sale->total <= 0) {

            // 🔥 DELETE sale_items if any left
            DB::table('sale_items')
                ->where('sale_id', $sale->id)
                ->delete();

            // 🔥 DELETE loans (ئەگەر قەرز بوو)
          
            // 🔥 DELETE sales
            DB::table('sales')
                ->where('id', $sale->id)
                ->delete();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'سەرکەوتوو',
            'return_total' => $returnTotal
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
    
  

    


}



    public function history(Request $request)
    {
        $perPage = $request->get('per_page', 20);

        $returns = DB::table('returns')
            ->join('users', 'returns.user_id', '=', 'users.id')
            ->select(
                'returns.*',
                'users.name as user_name'
            )
            ->orderBy('returns.created_at', 'desc')
            ->paginate($perPage);

        // Get items for each return
        foreach ($returns as $return) {
            $return->items = DB::table('return_items')
                ->join('products', 'return_items.product_id', '=', 'products.id')
                ->where('return_items.return_id', $return->id)
                ->select(
                    'return_items.*',
                    'products.name as product_name',
                    'products.barcode',
                    'products.image_producte_path'
                )
                ->get();
        }

        return response()->json([
            'success' => true,
            'returns' => $returns
        ]);
    }

    /**
     * Get return details
     */
    public function show($id)
    {
        $return = DB::table('returns')
            ->join('users', 'returns.user_id', '=', 'users.id')
            ->where('returns.id', $id)
            ->select(
                'returns.*',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->first();

        if (!$return) {
            return response()->json([
                'success' => false,
                'message' => 'گەڕاندنەوە نەدۆزرایەوە'
            ], 404);
        }

        $return->items = DB::table('return_items')
            ->join('products', 'return_items.product_id', '=', 'products.id')
            ->where('return_items.return_id', $id)
            ->select(
                'return_items.*',
                'products.name as product_name',
                'products.barcode',
                'products.image_producte_path'
            )
            ->get();

        return response()->json([
            'success' => true,
            'return' => $return
        ]);
    }

    /**
     * Get product sale history
     */
    public function getProductSaleHistory(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);

        try {
            $sales = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->where('sale_items.product_id', $request->product_id)
                ->select(
                    'sales.invoice_number',
                    'sale_items.created_at as date',
                    'sale_items.quantity',
                    'sale_items.selling_price',
                    'sale_items.total'
                )
                ->orderBy('sale_items.created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'invoice_number' => $item->invoice_number ?? 'N/A',
                        'date' => date('Y-m-d H:i', strtotime($item->date)),
                        'quantity' => $item->quantity,
                        'selling_price' => $item->selling_price,
                        'total' => $item->total
                    ];
                });

            return response()->json([
                'success' => true,
                'sales' => $sales
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel a return
     */
    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $return = DB::table('returns')->where('id', $id)->first();

            if (!$return) {
                return response()->json([
                    'success' => false,
                    'message' => 'گەڕاندنەوە نەدۆزرایەوە'
                ], 404);
            }

            if ($return->status !== 'completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'تەنها گەڕاندنەوەی تەواوکراو دەتوانرێت هەڵوەشێتەوە'
                ], 400);
            }

            // Get return items
            $items = DB::table('return_items')
                ->where('return_id', $id)
                ->get();

            // Revert stock changes (decrease inventory)
            foreach ($items as $item) {
                DB::table('products')
                    ->where('id', $item->product_id)
                    ->decrement('minimum_wearhouse', $item->quantity);

                // Create stock adjustment for cancellation
                DB::table('stock_adjustments')->insert([
                    'product_id' => $item->product_id,
                    'type' => 'return_cancelled',
                    'quantity' => -$item->quantity,
                    'reference' => $return->return_number,
                    'notes' => 'Return cancelled',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Update return status
            DB::table('returns')
                ->where('id', $id)
                ->update([
                    'status' => 'cancelled',
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'گەڕاندنەوە بە سەرکەوتوویی هەڵوەشایەوە'
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
     * Get return statistics
     */
    public function statistics()
    {
        $totalReturns = DB::table('returns')->count();
        $totalAmount = DB::table('returns')->sum('total');
        $todayReturns = DB::table('returns')
            ->whereDate('created_at', today())
            ->count();
        $todayAmount = DB::table('returns')
            ->whereDate('created_at', today())
            ->sum('total');

        $returnsByReason = DB::table('returns')
            ->select('reason', DB::raw('count(*) as count'), DB::raw('sum(total) as total'))
            ->groupBy('reason')
            ->get();

        $recentReturns = DB::table('returns')
            ->join('users', 'returns.user_id', '=', 'users.id')
            ->select(
                'returns.return_number',
                'returns.total',
                'returns.reason',
                'returns.created_at',
                'users.name as user_name'
            )
            ->orderBy('returns.created_at', 'desc')
            ->limit(10)
            ->get();

        $topReturnedProducts = DB::table('return_items')
            ->join('products', 'return_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                'products.barcode',
                DB::raw('SUM(return_items.quantity) as total_returned'),
                DB::raw('SUM(return_items.total) as total_amount')
            )
            ->groupBy('products.id', 'products.name', 'products.barcode')
            ->orderBy('total_returned', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'statistics' => [
                'total_returns' => $totalReturns,
                'total_amount' => $totalAmount,
                'today_returns' => $todayReturns,
                'today_amount' => $todayAmount,
                'by_reason' => $returnsByReason,
                'recent' => $recentReturns,
                'top_products' => $topReturnedProducts
            ]
        ]);
    }
}
