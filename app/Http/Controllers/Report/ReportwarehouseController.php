<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportwarehouseController extends Controller
{
    /**
     * لیستی کاڵا کەمەکان (counter < 3) + هەموو ئەو کاڵایانەی داواکارییان هەیە
     */
    public function criticalList(Request $request)
    {
        try {
            $products = DB::table('products as p')
                ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')     // ⭐ JOIN
                ->leftJoin('product_requests as pr', function ($join) {
                    $join->on('p.id', '=', 'pr.product_id')
                         ->where('pr.status', '=', 'pending');
                })
                ->select([
                    'p.id as product_id',
                    'p.name as product_name',
                    'c.company_name',                                          // ⭐
                    'p.image_producte_path',
                    'p.purchase_price',
                    'p.selling_price',
                    'p.in_critical_list',
                    'pr.id as request_id',
                    'pr.quantity as requested_quantity',
                    'pr.status as request_status',
                    'pr.notes',
                    'pr.requested_by',
                    'pr.approved_by',
                    DB::raw('COALESCE(w.counter, 0) as counter'),
                    DB::raw('COALESCE(w.counter, 0) as quantity')
                ])
                ->where(function ($query) {
                    $query->where('w.counter', '<', 3)
                          ->orWhereNull('w.counter')
                          ->orWhereNotNull('pr.id');
                })
                ->orderBy('counter', 'asc')
                ->get();

            $products->transform(function ($product) {
                $product->image = !empty($product->image_producte_path)
                    ? asset('images/products/' . ltrim($product->image_producte_path, '/'))
                    : asset('images/placeholder.png');

                $product->purchase_price = number_format($product->purchase_price ?? 0, 2);
                $product->selling_price  = number_format($product->selling_price ?? 0, 2);

                $product->status = $product->request_status ?? 'none';
                $product->requested_quantity = $product->requested_quantity ?? 0;

                return $product;
            });

            return response()->json([
                'success' => true,
                'data'    => $products,
                'total'   => $products->count(),
                'message' => 'کاڵا کەمەکان و داواکارییەکان بارکران'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ڕاپۆرتی گشتی کۆگا
     * ✅ لەگەڵ کۆمپانیا (company_name)
     */
    public function report(Request $request)
    {
        try {
            $query = DB::table('products as p')
                ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')     // ⭐ JOIN
                ->leftJoin('N_Vouchers as nv', 'nv.product_id', '=', 'p.id')
                ->leftJoin('Vouchers as v', 'v.id', '=', 'nv.Voucher_id')
                ->select([
                    'p.id',
                    'p.barcode',
                    'p.name',
                    'c.company_name',                                          // ⭐
                    'p.purchase_price',
                    'p.selling_price',
                    'p.image_producte_path',
                    'v.voucher_name',
                    'nv.Voucher_id',
                    DB::raw('COALESCE(w.counter, 0) as counter'),
                    DB::raw('COALESCE(p.in_critical_list, 0) as in_critical_list')
                ]);

            if ($request->filled('name')) {
                $query->where('p.name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('barcode')) {
                $query->where('p.barcode', 'like', '%' . $request->barcode . '%');
            }
            if ($request->filled('company')) {
                $query->where('c.company_name', 'like', '%' . $request->company . '%');  // ⭐
            }
            if ($request->filled('voucher')) {
                $query->where('v.voucher_name', 'like', '%' . $request->voucher . '%');
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
                            $q->where('w.counter', 0)
                              ->orWhereNull('w.counter');
                        });
                        break;
                    case 'negative':
                        $query->where('w.counter', '<', 0);
                        break;
                }
            }

            $query->groupBy(
                'p.id',
                'p.barcode',
                'p.name',
                'c.company_name',
                'p.purchase_price',
                'p.selling_price',
                'p.image_producte_path',
                'v.voucher_name',
                'nv.Voucher_id',
                'w.counter',
                'p.in_critical_list'
            );

            $query->orderBy('w.counter', 'asc');

            $perPage  = $request->get('per_page', 15);
            $products = $query->paginate($perPage);

            // Statistics
            $statsQuery = DB::table('products as p')
                ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')     // ⭐ JOIN
                ->leftJoin('N_Vouchers as nv', 'nv.product_id', '=', 'p.id')
                ->leftJoin('Vouchers as v', 'v.id', '=', 'nv.Voucher_id');

            if ($request->filled('name')) {
                $statsQuery->where('p.name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('barcode')) {
                $statsQuery->where('p.barcode', 'like', '%' . $request->barcode . '%');
            }
            if ($request->filled('company')) {
                $statsQuery->where('c.company_name', 'like', '%' . $request->company . '%');  // ⭐
            }
            if ($request->filled('voucher')) {
                $statsQuery->where('v.voucher_name', 'like', '%' . $request->voucher . '%');
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

            return response()->json([
                'success'      => true,
                'data'         => $products->items(),
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
                'statistics'   => $statistics
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * زیادکردن کاڵا بۆ دوکان
     */
    public function addToStore(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity'   => 'required|integer|min:1'
            ]);

            DB::beginTransaction();

            DB::table('product_wearhouse')
                ->where('id_product', $request->product_id)
                ->update([
                    'counter' => DB::raw('COALESCE(counter,0) + ' . (int)$request->quantity)
                ]);

            $counter_w = DB::table('product_wearhouse')
                ->where('id_product', $request->product_id)
                ->first();

            DB::table('products')
                ->where('id', $request->product_id)
                ->update([
                    'minimum_wearhouse' => $counter_w->counter,
                    'in_critical_list'  => 0
                ]);

            DB::table('product_requests')
                ->where('product_id', $request->product_id)
                ->where('status', 'pending')
                ->update([
                    'status'      => 'approved',
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

    /**
     * سڕینەوە لە لیستی کاڵا کەمەکان
     */
    public function deleteFromCriticalList(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id'
            ]);

            DB::table('product_requests')
                ->where('product_id', $request->product_id)
                ->where('status', 'pending')
                ->delete();

            $counter = DB::table('product_wearhouse')
                ->where('id_product', $request->product_id)
                ->value('counter');

            if ($counter === null || $counter < 3) {
                DB::table('products')
                    ->where('id', $request->product_id)
                    ->update(['in_critical_list' => 0]);
            }

            return response()->json([
                'success' => true,
                'message' => 'بە سەرکەوتوویی سڕایەوە'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * هەناردەکردنی لیستی کاڵا کەمەکان بۆ PDF
     */
    public function exportCriticalListPDF()
    {
        try {
            $products = DB::table('products as p')
                ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')     // ⭐ JOIN
                ->leftJoin('product_requests as pr', function ($join) {
                    $join->on('p.id', '=', 'pr.product_id')
                         ->where('pr.status', '=', 'pending');
                })
                ->select([
                    'p.name',
                    'c.company_name',                                          // ⭐
                    'p.image_producte_path',
                    'pr.quantity as requested_quantity',
                    DB::raw('COALESCE(w.counter,0) as counter')
                ])
                ->where(function ($query) {
                    $query->where('w.counter', '<', 3)
                          ->orWhereNull('w.counter')
                          ->orWhereNotNull('pr.id');
                })
                ->orderBy('counter', 'asc')
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'هیچ کاڵایەک نییە'
                ]);
            }

            $pdf = Pdf::loadView('exports.critical_list_pdf', [
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
     * زیادکردن بۆ لیستی کاڵا کەمەکان (داواکاری)
     */
    public function addToCriticalList(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity'   => 'nullable|integer|min:1',
                'notes'      => 'nullable|string|max:500',
            ]);

            $product = DB::table('products')
                ->where('id', $request->product_id)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'کاڵاکە نەدۆزرایەوە'
                ], 404);
            }

            $existingRequest = DB::table('product_requests')
                ->where('product_id', $request->product_id)
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'ئەم کاڵایە پێشتر داواکارییەکی چاوەڕوانی هەیە'
                ], 400);
            }

            DB::table('products')
                ->where('id', $request->product_id)
                ->update(['in_critical_list' => 1]);

            $quantity = $request->quantity ?? 1;
            $notes    = $request->notes ?? '';

            DB::table('product_requests')->insert([
                'product_id'   => $request->product_id,
                'quantity'     => $quantity,
                'status'       => 'pending',
                'notes'        => $notes,
                'requested_by' => Auth::id(),
                'approved_by'  => 0,
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

    /**
     * هەناردەکردنی Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $query = DB::table('products as p')
                ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')     // ⭐ JOIN
                ->select([
                    'p.id',
                    'p.barcode',
                    'p.name',
                    'c.company_name',                                          // ⭐
                    'p.purchase_price',
                    'p.selling_price',
                    DB::raw('COALESCE(w.counter, 0) as counter')
                ]);

            if ($request->filled('name')) {
                $query->where('p.name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('company')) {
                $query->where('c.company_name', 'like', '%' . $request->company . '%');  // ⭐
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

            $query->orderBy('w.counter', 'asc');
            $products = $query->get();

            return response()->json([
                'success' => true,
                'data'    => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * هەناردەکردنی PDF
     */
    public function exportPDF(Request $request)
    {
        try {
            $query = DB::table('products as p')
                ->leftJoin('product_wearhouse as w', 'p.id', '=', 'w.id_product')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')     // ⭐ JOIN
                ->select([
                    'p.id',
                    'p.barcode',
                    'p.name',
                    'c.company_name',                                          // ⭐
                    'p.purchase_price',
                    'p.selling_price',
                    DB::raw('COALESCE(w.counter, 0) as counter')
                ]);

            if ($request->filled('name')) {
                $query->where('p.name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('company')) {
                $query->where('c.company_name', 'like', '%' . $request->company . '%');  // ⭐
            }

            $query->orderBy('w.counter', 'asc');
            $products = $query->get();

            return response()->json([
                'success' => true,
                'data'    => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}