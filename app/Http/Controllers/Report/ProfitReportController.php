<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ProfitReportController extends Controller
{
    /**
     * Get profit report data grouped by product
     */
    public function getProfitReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $search = $request->input('search');
            $company = $request->input('company');

            // ============================================
            // 1. GET SALE ITEMS GROUPED BY PRODUCT
            // ✅ چاککراوە: بەستن بە product_id و companies
            // ============================================
            $itemsQuery = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->leftJoin('products', 'sale_items.product_id', '=', 'products.id')
                ->leftJoin('companies', 'companies.id', '=', 'products.company_id')
                ->select(
                    'sale_items.product_name',
                    'sale_items.product_id',
                    DB::raw('COALESCE(companies.company_name, products.company, "---") as company'),
                    'sale_items.purchase_price',
                    'sale_items.selling_price',
                    DB::raw('SUM(sale_items.quantity) as total_quantity'),
                    DB::raw('SUM(sale_items.purchase_price * sale_items.quantity) as total_purchase'),
                    DB::raw('SUM(sale_items.selling_price * sale_items.quantity) as total_sale'),
                    DB::raw('SUM((sale_items.selling_price - sale_items.purchase_price) * sale_items.quantity) as profit'),
                    DB::raw('SUM(sales.discount) as total_discount')
                )
                ->groupBy(
                    'sale_items.product_name',
                    'sale_items.product_id',
                    'companies.company_name',
                    'products.company',
                    'sale_items.purchase_price',
                    'sale_items.selling_price'
                );

            if ($startDate && $endDate) {
                $itemsQuery->whereBetween(DB::raw('DATE(sales.created_at)'), [$startDate, $endDate]);
            }

            if ($search) {
                $itemsQuery->where(function($q) use ($search) {
                    $q->where('sale_items.product_name', 'LIKE', '%' . $search . '%');
                    $q->orWhere('products.barcode', 'LIKE', '%' . $search . '%');
                });
            }

            if ($company) {
                $itemsQuery->where(function($q) use ($company) {
                    $q->where('companies.company_name', 'LIKE', '%' . $company . '%');
                    $q->orWhere('products.company', 'LIKE', '%' . $company . '%');
                });
            }

            $items = $itemsQuery->orderBy('total_sale', 'desc')->get();

            // ============================================
            // 2. GET TOTAL LOANS (با فلته‌رەکانیش لەسەری کاربکەن)
            // ============================================
            $loansQuery = DB::table('loans')
                ->whereIn('loans.invoice_number', function($subQuery) use ($startDate, $endDate, $search, $company) {
                    $subQuery->select('sales.invoice_number')
                        ->from('sales')
                        ->join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
                        ->leftJoin('products', 'sale_items.product_id', '=', 'products.id')
                        ->leftJoin('companies', 'companies.id', '=', 'products.company_id');
                    
                    if ($startDate && $endDate) {
                        $subQuery->whereBetween(DB::raw('DATE(sales.created_at)'), [$startDate, $endDate]);
                    }
                    
                    if ($search) {
                        $subQuery->where(function($q) use ($search) {
                            $q->where('sale_items.product_name', 'LIKE', '%' . $search . '%');
                            $q->orWhere('products.barcode', 'LIKE', '%' . $search . '%');
                        });
                    }
                    
                    if ($company) {
                        $subQuery->where(function($q) use ($company) {
                            $q->where('companies.company_name', 'LIKE', '%' . $company . '%');
                            $q->orWhere('products.company', 'LIKE', '%' . $company . '%');
                        });
                    }
                });

            if ($startDate && $endDate) {
                $loansQuery->whereBetween(DB::raw('DATE(loans.created_at)'), [$startDate, $endDate]);
            }

            $totalLoans = $loansQuery->sum('loans.total');

            // ============================================
            // 3. 🔴 GET TOTAL DISCOUNT
            // ============================================
            $totalDiscount = $items->sum('total_discount');

            // ============================================
            // 4. CALCULATE TOTALS
            // ============================================
            $totalSales = $items->sum('total_sale');
            $totalPurchase = $items->sum('total_purchase');
            $totalProfit = $items->sum('profit');
            $totalItemsSold = $items->sum('total_quantity');

            // ============================================
            // 5. FORMAT REPORT DATA
            // ============================================
            $reportData = [];
            foreach ($items as $item) {
                $reportData[] = [
                    'product_name' => $item->product_name,
                    'company' => $item->company ?? '---',
                    'total_quantity' => (int)$item->total_quantity,
                    'purchase_price' => (float)$item->purchase_price,
                    'total_purchase' => (float)$item->total_purchase,
                    'sale_price' => (float)$item->selling_price,
                    'total_sale' => (float)$item->total_sale,
                    'discount' => (float)($item->total_discount ?? 0),
                    'total_discount' => (float)($item->total_discount ?? 0),
                    'profit' => (float)$item->profit,
                ];
            }

            return response()->json([
                'success' => true,
                'report' => $reportData,
                'summary' => [
                    'total_sales' => $totalSales,
                    'total_purchase' => $totalPurchase,
                    'total_profit' => $totalProfit,
                    'total_items_sold' => $totalItemsSold,
                    'total_loans' => $totalLoans,
                    'total_discount' => $totalDiscount,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getProfitReport: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error loading profit report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export profit report to PDF
     */
    public function exportPDF(Request $request)
    {
        try {
            $response = $this->getProfitReport($request);
            $data = $response->getData(true);

            if (!$data['success']) {
                return response()->json(['success' => false, 'message' => $data['message']], 500);
            }

            $pdf = PDF::loadView('reports.profit_report_pdf', [
                'report' => $data['report'],
                'summary' => $data['summary'],
                'startDate' => $request->input('start_date'),
                'endDate' => $request->input('end_date'),
            ]);

            return $pdf->download('profit_report_' . $request->input('start_date') . '_to_' . $request->input('end_date') . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}