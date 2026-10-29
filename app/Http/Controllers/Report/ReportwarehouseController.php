<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Auth;
class ReportwarehouseController extends Controller
{

public function criticalList(Request $request)
{
    try {

        $requests = DB::table('product_requests as pr')
            ->leftJoin('products as p', 'pr.product_id', '=', 'p.id')
            ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
            ->select([
                'pr.id',
                'pr.product_id',
                'pr.quantity',
                'pr.status',
                'pr.notes',
                'pr.requested_by',
                'pr.approved_by',
                'p.name as product_name',
                'p.company',
                'p.image_producte_path',
                'p.purchase_price',
                'p.selling_price',
                'p.in_critical_list',
                DB::raw('COALESCE(w.counter,0) as counter')
            ])
            ->orderBy('pr.id', 'desc')
            ->get();

        // transform
        $requests->transform(function ($request) {

            $request->image = !empty($request->image_producte_path)
                ? asset('images/products/' . ltrim($request->image_producte_path, '/'))
                : asset('images/placeholder.png');

            $request->purchase_price = number_format($request->purchase_price ?? 0, 2);
            $request->selling_price = number_format($request->selling_price ?? 0, 2);

            return $request;
        });

        return response()->json([
            'success' => true,
            'data' => $requests,
            'total' => $requests->count(),
            'message' => 'Requests loaded'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

 public function report(Request $request)
{
    try {
        $query = DB::table('products as p')
            ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
            ->select([
                'p.id',
                'p.barcode',
                'p.name',
                'p.company',
                'p.purchase_price',
                'p.selling_price',
                'p.image_producte_path',   
                DB::raw('COALESCE(w.counter, 0) as counter'),
                DB::raw('COALESCE(p.in_critical_list, 0) as in_critical_list')
            ]);

        // 🔍 Filters
        if ($request->filled('name')) {
            $query->where('p.name', 'like', '%' . $request->name . '%');
        }

        // ✅ ADD BARCODE FILTER HERE
        if ($request->filled('barcode')) {
            $query->where('p.barcode', 'like', '%' . $request->barcode . '%');
        }

        if ($request->filled('company')) {
            $query->where('p.company', 'like', '%' . $request->company . '%');
        }

        // 📦 Stock filter
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'normal':
                    $query->where('w.counter', '>', 10);
                    break;
                case 'low':
                    $query->whereBetween('w.counter', [1, 10]);
                    break;
                case 'critical':
                    $query->whereBetween('w.counter', [1, 2]);
                    break;
                case 'out':
                    $query->where(function ($q) {
                        $q->where('w.counter', 0)
                          ->orWhereNull('w.counter');
                    });
                    break;
                case 'negative':
                    $query->where('w.counter', '<', 0);
                    break;
            }
        }

        // 🔄 Sorting - Always sort by counter ascending
        $query->orderBy('w.counter', 'asc');

        // ✅ Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        // 📊 Statistics (applied with same filters)
        $statsQuery = DB::table('products as p')
            ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product');
        
        // Apply same filters to statistics
        if ($request->filled('name')) {
            $statsQuery->where('p.name', 'like', '%' . $request->name . '%');
        }
        
        // ✅ ADD BARCODE FILTER TO STATISTICS TOO
        if ($request->filled('barcode')) {
            $statsQuery->where('p.barcode', 'like', '%' . $request->barcode . '%');
        }
        
        if ($request->filled('company')) {
            $statsQuery->where('p.company', 'like', '%' . $request->company . '%');
        }
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'normal':
                    $statsQuery->where('w.counter', '>', 10);
                    break;
                case 'low':
                    $statsQuery->whereBetween('w.counter', [1, 10]);
                    break;
                case 'critical':
                    $statsQuery->whereBetween('w.counter', [1, 2]);
                    break;
                case 'out':
                    $statsQuery->where(function ($q) {
                        $q->where('w.counter', 0)
                          ->orWhereNull('w.counter');
                    });
                    break;
                case 'negative':
                    $statsQuery->where('w.counter', '<', 0);
                    break;
            }
        }
        
        $statistics = $statsQuery->selectRaw("
                COUNT(DISTINCT p.id) as total_products,
                SUM(COALESCE(w.counter, 0) * COALESCE(p.purchase_price, 0)) as total_purchase_value,
                SUM(COALESCE(w.counter, 0) * COALESCE(p.selling_price, 0)) as total_selling_value,
                SUM(
                    (COALESCE(w.counter, 0) * COALESCE(p.selling_price, 0)) -
                    (COALESCE(w.counter, 0) * COALESCE(p.purchase_price, 0))
                ) as total_profit
            ")
            ->first();

        // Return response matching frontend expectations
        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
            'statistics' => $statistics
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function addToStore(Request $request)
{
    try {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        // 🔻 زیادکردن لە warehouse
        DB::table('product_wearhouse')
            ->where('id_product', $request->product_id)
            ->update([
                'counter' => DB::raw('COALESCE(counter,0) + ' . (int)$request->quantity)
            ]);

        $counter_w = DB::table('product_wearhouse')
            ->where('id_product', $request->product_id)
            ->first();

        // 🔄 نوێکردنەوەی minimum لە products
        DB::table('products')
            ->where('id', $request->product_id)
            ->update([
                'minimum_wearhouse' => $counter_w->counter,
                "in_critical_list" => 1
            ]);

        DB::table('products')
            ->where('id', $request->product_id)
            ->update([
                'in_critical_list' => 0
            ]);

        // 🔄 نوێکردنەوەی داواکارییە پەسەندکراوەکان
        DB::table('product_requests')
            ->where('product_id', $request->product_id)
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
            ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'بە سەرکەوتوویی نوێکرایەوە'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


public function deleteFromCriticalList(Request $request)
{
    try {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // سڕینەوەی in_critical_list لە products
        DB::table('products')
            ->where('id', $request->product_id)
            ->update(['in_critical_list' => 0]);

        // ڕەتکردنەوەی داواکارییە pendingـەکانی ئەم کاڵایە
        DB::table('product_requests')
            ->where('product_id', $request->product_id)
            ->where('status', 'pending')
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'کاڵاکە بە سەرکەوتوویی لە لیست سڕایەوە'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
        ], 500);
    }
}


/**
 * Export critical list to PDF
 */
public function exportCriticalListPDF()
{
    try {

        $products = DB::table('products as p')
            ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
            ->select([
                'p.name',
                'p.company',
                'p.image_producte_path',
                DB::raw('COALESCE(w.counter,0) as counter')
            ])
            ->where(function ($query) {
                $query->where('w.counter', '<', 3)
                      ->orWhereNull('w.counter');
            })
            ->orderBy('counter', 'asc')
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'هیچ کاڵایەک نییە'
            ]);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.critical_list_pdf', [
            'products' => $products
        ]);

        return $pdf->download('critical_list_report.pdf');

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
    /**
     * Add product to critical list (products with quantity less than 3)
     */
  public function addToCriticalList(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'nullable|integer|min:1',
                'notes' => 'nullable|string|max:500',
            ]);

            // Check if product exists
            $product = DB::table('products')
                ->where('id', $request->product_id)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'کاڵاکە نەدۆزرایەوە'
                ], 404);
            }

            // Check if already in critical list
            if (isset($product->in_critical_list) && $product->in_critical_list == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'ئەم کاڵایە پێشتر خراوەتە ناوی لیستی کەمترین بڕ'
                ], 400);
            }

            // Add to critical list (update the products table)
            DB::table('products')
                ->where('id', $request->product_id)
                ->update(['in_critical_list' => 1]);

            // تۆمارکردنی داواکاری لە خشتەی product_requests
            $quantity = $request->quantity ?? 1;
            $notes = $request->notes ?? '';
            
            DB::table('product_requests')->insert([
                'product_id' => $request->product_id,
                'quantity' => $quantity,
                'status' => 'pending',
                'notes' => $notes,
                'requested_by' => Auth::id(),
                'approved_by' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'داواکارییەکەت بە سەرکەوتوویی تۆمار کرا'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $query = DB::table('products as p')
                ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
                ->select([
                    'p.id',
                    'p.barcode',
                    'p.name',
                    'p.company',
                    'p.purchase_price',
                    'p.selling_price',
                    DB::raw('COALESCE(w.counter, 0) as counter')
                ]);

            // Apply filters
            if ($request->filled('name')) {
                $query->where('p.name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('company')) {
                $query->where('p.company', 'like', '%' . $request->company . '%');
            }
            if ($request->filled('stock_status')) {
                switch ($request->stock_status) {
                    case 'normal':
                        $query->where('w.counter', '>', 10);
                        break;
                    case 'low':
                        $query->whereBetween('w.counter', [1, 10]);
                        break;
                    case 'critical':
                        $query->whereBetween('w.counter', [1, 2]);
                        break;
                    case 'out':
                        $query->where(function ($q) {
                            $q->where('w.counter', 0)->orWhereNull('w.counter');
                        });
                        break;
                    case 'negative':
                        $query->where('w.counter', '<', 0);
                        break;
                }
            }

            // Sort by counter ascending
            $query->orderBy('w.counter', 'asc');

            $products = $query->get();
            
            // Generate Excel file (you'll need Maatwebsite/Excel package)
            // For now, return JSON
            return response()->json([
                'success' => true,
                'data' => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function exportPDF(Request $request)
    {
        try {
            $query = DB::table('products as p')
                ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
                ->select([
                    'p.id',
                    'p.barcode',
                    'p.name',
                    'p.company',
                    'p.purchase_price',
                    'p.selling_price',
                    DB::raw('COALESCE(w.counter, 0) as counter')
                ]);

            // Apply filters (same as above)
            if ($request->filled('name')) {
                $query->where('p.name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('company')) {
                $query->where('p.company', 'like', '%' . $request->company . '%');
            }

            // Sort by counter ascending
            $query->orderBy('w.counter', 'asc');

            $products = $query->get();
            
            // Generate PDF (you'll need Barryvdh/DomPDF package)
            // For now, return JSON
            return response()->json([
                'success' => true,
                'data' => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}