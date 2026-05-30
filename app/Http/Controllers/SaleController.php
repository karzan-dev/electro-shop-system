<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display sales page
     */
    public function index()
    {
        $nextVoucherNumber = $this->getNextInvoiceNumber();
        $currentDollarRate = $this->getCurrentDollarRate();

        return view('sales.index', compact('nextVoucherNumber', 'currentDollarRate'));
    }


    // لە فایلی app/Http/Controllers/SaleController.php

/**
 * Get next voucher number via AJAX
 */
public function getNextVoucherNumber()
{
    try {
        $nextVoucherNumber = $this->getNextInvoiceNumber();

        return response()->json([
            'success' => true,
            'voucher_number' => $nextVoucherNumber
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Get next invoice number
     */
    private function getNextInvoiceNumber()
    {
        $lastSale = DB::table('sales')
                     ->orderBy('id', 'desc')
                     ->first();

        if (!$lastSale) {
            return 'INV-0001';
        }

        $lastNumber = intval(substr($lastSale->invoice_number, 4));
        $newNumber = $lastNumber + 1;
        return 'INV-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get current dollar rate
     */
    private function getCurrentDollarRate()
    {
        $setting = DB::table('settings')
                    ->where('key', 'dollar_rate')
                    ->first();

        return $setting ? $setting->value : 1450;
    }

    /**
     * Store a newly created sale
     */
    public function store(Request $request)
    {
        try {
            // Get all data
            $data = $request->all();

            // Parse items if they're string
            if (isset($data['items']) && is_string($data['items'])) {
                $data['items'] = json_decode($data['items'], true);
            }

            // Validation rules
            $validator = Validator::make($data, [
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|integer',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'subtotal' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // Check stock for all items from product_wearhouse
            foreach ($data['items'] as $item) {
                $product = DB::table('products')->where('id', $item['id'])->first();

                if (!$product) {
                    throw new \Exception("Product not found: ID {$item['id']}");
                }

                // Get total counter from product_wearhouse for this product
                $totalStock = DB::table('product_wearhouse')
                              ->where('id_product', $item['id'])
                              ->sum('counter');

                if ($totalStock < $item['quantity']) {
                    throw new \Exception(
                        "بڕی کۆگای {$product->name} تەواوە. ماوە: {$totalStock}"
                    );
                }
            }

            // Create sale
            $invoiceNumber = $this->getNextInvoiceNumber();
            $saleId = DB::table('sales')->insertGetId([
                'invoice_number' => $invoiceNumber,
                'user_id' => Auth::id() ?? 1,
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'],
                'total' => $data['total'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create sale items and update stock in product_wearhouse
            foreach ($data['items'] as $item) {
                $product = DB::table('products')->where('id', $item['id'])->first();

                // Insert sale item
                DB::table('sale_items')->insert([
                    'sale_id' => $saleId,
                    'product_id' => $item['id'],
                    'product_name' => $product->name,
                    'purchase_price' => $product->purchase_price ?? 0,
                    'selling_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update counter in product_wearhouse
                // We need to decrement from one or more wearhouse records
                $remainingQuantity = $item['quantity'];
                $wearhouseRecords = DB::table('product_wearhouse')
                                    ->where('id_product', $item['id'])
                                    ->where('counter', '>', 0)
                                    ->orderBy('id') // Can be ordered by expiry date or any preferred method
                                    ->get();

                foreach ($wearhouseRecords as $wearhouse) {
                    if ($remainingQuantity <= 0) break;

                    if ($wearhouse->counter >= $remainingQuantity) {
                        // This wearhouse has enough stock
                        DB::table('product_wearhouse')
                          ->where('id', $wearhouse->id)
                          ->decrement('counter', $remainingQuantity);
                        $remainingQuantity = 0;
                    } else {
                        // Take all from this wearhouse and continue to next
                        DB::table('product_wearhouse')
                          ->where('id', $wearhouse->id)
                          ->decrement('counter', $wearhouse->counter);
                        $remainingQuantity -= $wearhouse->counter;
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'فرۆشتن بە سەرکەوتوویی تۆمارکرا',
                'sale_id' => $saleId,
                'invoice_number' => $invoiceNumber,
                'new_invoice_number' => $this->getNextInvoiceNumber(),
                'print_url' => route('sales.print', $saleId)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified sale
     */
    public function show($id)
    {
        $sale = DB::table('sales')->where('id', $id)->first();

        if (!$sale) {
            return redirect()->route('sales.index')
                            ->with('error', 'فرۆشتن نەدۆزرایەوە');
        }

        $items = DB::table('sale_items')
                  ->where('sale_id', $id)
                  ->get();

        return view('sales.show', compact('sale', 'items'));
    }

    /**
     * Print invoice
     */
    public function printInvoice($id)
    {
        $sale = DB::table('sales')->where('id', $id)->first();

        if (!$sale) {
            return redirect()->route('sales.index')
                            ->with('error', 'فرۆشتن نەدۆزرایەوە');
        }

        $items = DB::table('sale_items')
                  ->where('sale_id', $id)
                  ->get();

        return view('sales.print', compact('sale', 'items'));
    }

    /**
     * Search product by barcode
     */
    public function searchByBarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بارکۆد پێویستە'
            ], 422);
        }

        $product = DB::table('products')
                    ->where('barcode', $request->barcode)
                    ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'کاڵا نەدۆزرایەوە'
            ]);
        }

        // Get total stock from product_wearhouse
        $totalStock = DB::table('product_wearhouse')
                      ->where('id_product', $product->id)
                      ->sum('counter');

        $product->stock = $totalStock;

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Search product by name
     */
    public function searchByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'ناوی کاڵا پێویستە'
            ], 422);
        }

        $products = DB::table('products')
                     ->where('name', 'LIKE', '%' . $request->name . '%')
                     ->limit(10)
                     ->get();

        // Add stock from product_wearhouse for each product
        foreach ($products as $product) {
            $totalStock = DB::table('product_wearhouse')
                          ->where('id_product', $product->id)
                          ->sum('counter');
            $product->stock = $totalStock;
        }

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    /**
     * Get sales by date range
     */
    public function getByDateRange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $sales = DB::table('sales')
                  ->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59'])
                  ->orderBy('created_at', 'desc')
                  ->get();

        $total = DB::table('sales')
                  ->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59'])
                  ->sum('total');

        return response()->json([
            'success' => true,
            'sales' => $sales,
            'total' => $total,
            'count' => $sales->count()
        ]);
    }

    /**
     * Get today's sales
     */
    public function getTodaySales()
    {
        $sales = DB::table('sales')
                  ->whereDate('created_at', today())
                  ->orderBy('created_at', 'desc')
                  ->get();

        $total = DB::table('sales')
                  ->whereDate('created_at', today())
                  ->sum('total');

        return response()->json([
            'success' => true,
            'sales' => $sales,
            'total' => $total,
            'count' => $sales->count()
        ]);
    }

    /**
     * Cancel sale
     */
    public function cancel($id)
    {
        DB::beginTransaction();

        try {
            $sale = DB::table('sales')->where('id', $id)->first();

            if (!$sale) {
                throw new \Exception('فرۆشتن نەدۆزرایەوە');
            }

            if ($sale->payment_status === 'cancelled') {
                throw new \Exception('فرۆشتن پێشتر هەڵوەشاوەتەوە');
            }

            // Get sale items
            $items = DB::table('sale_items')
                      ->where('sale_id', $id)
                      ->get();

            // Return stock to product_wearhouse
            foreach ($items as $item) {
                // We need to add stock back to product_wearhouse
                // This is simplified - you might want to track which wearhouse it came from
                $wearhouseRecord = DB::table('product_wearhouse')
                                   ->where('id_product', $item->product_id)
                                   ->orderBy('id')
                                   ->first();

                if ($wearhouseRecord) {
                    DB::table('product_wearhouse')
                      ->where('id', $wearhouseRecord->id)
                      ->increment('counter', $item->quantity);
                } else {
                    // Create new record if none exists
                    DB::table('product_wearhouse')->insert([
                        'id_product' => $item->product_id,
                        'counter' => $item->quantity,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Update sale status
            DB::table('sales')
              ->where('id', $id)
              ->update([
                  'payment_status' => 'cancelled',
                  'updated_at' => now()
              ]);

            DB::commit();

            return redirect()->back()
                            ->with('success', 'فرۆشتن هەڵوەشایەوە');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                            ->with('error', 'هەڵەیەک ڕوویدا: ' . $e->getMessage());
        }
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats()
    {
        // Get total stock from product_wearhouse
        $totalProducts = DB::table('products')->count();

        $lowStock = 0;
        $outOfStock = 0;

        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $totalStock = DB::table('product_wearhouse')
                          ->where('id_product', $product->id)
                          ->sum('counter');

            if ($totalStock <= 0) {
                $outOfStock++;
            } elseif ($totalStock <= 5) {
                $lowStock++;
            }
        }

        $stats = [
            'today_sales' => DB::table('sales')->whereDate('created_at', today())->count(),
            'today_revenue' => DB::table('sales')->whereDate('created_at', today())->sum('total'),
            'month_sales' => DB::table('sales')
                              ->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count(),
            'month_revenue' => DB::table('sales')
                               ->whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->sum('total'),
            'total_products' => $totalProducts,
            'low_stock' => $lowStock,
            'out_of_stock' => $outOfStock
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Get product stock from wearhouse
     */
    public function getProductStock($productId)
    {
        $totalStock = DB::table('product_wearhouse')
                      ->where('id_product', $productId)
                      ->sum('counter');

        $wearhouseDetails = DB::table('product_wearhouse')
                            ->where('id_product', $productId)
                            ->get();

        return response()->json([
            'success' => true,
            'total_stock' => $totalStock,
            'wearhouse_details' => $wearhouseDetails
        ]);
    }
}
