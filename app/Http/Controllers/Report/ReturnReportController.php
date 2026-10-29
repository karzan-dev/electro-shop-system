<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ReturnReportController extends Controller
{
    /**
     * Display the returns report page
     */
    public function index()
    {
        return view('items.report.reports-return-items');
    }

    /**
     * Get returns data for the report with filters
     */
    public function returnsReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $cashierId = $request->input('cashier_id');
            $reason = $request->input('reason');

            // Build the base query
            $query = DB::table('return_items')
                ->leftJoin('sales', 'return_items.seles_id', '=', 'sales.id')
                ->leftJoin('users', 'return_items.Casher_id', '=', 'users.id')
                ->select(
                    'return_items.id',
                    'return_items.seles_id',
                    'return_items.Item_Code',
                    'return_items.Amount',
                    'return_items.Metar',
                    'return_items.Sale_Price',
                    'return_items.Return_Total',
                    'return_items.Return_Cause',
                    'return_items.Casher_id',
                    'return_items.Return_Date',
                    'return_items.created_at',
                    'return_items.updated_at',
                    'sales.id as sale_id',
                    'sales.invoice_number',
                    'users.id as user_id',
                    'users.name as cashier_name',
                    // Determine reason code from Return_Cause text
                    DB::raw("
                        CASE 
                            WHEN return_items.Return_Cause LIKE '%شکاو%' OR return_items.Return_Cause LIKE '%زیان%' OR return_items.Return_Cause LIKE '%damaged%' THEN 'damaged'
                            WHEN return_items.Return_Cause LIKE '%تێکچو%' OR return_items.Return_Cause LIKE '%کار ناکات%' OR return_items.Return_Cause LIKE '%defective%' THEN 'defective'
                            WHEN return_items.Return_Cause LIKE '%گۆڕین%' OR return_items.Return_Cause LIKE '%exchange%' THEN 'exchange'
                            ELSE 'other'
                        END as reason_code
                    ")
                );

            // Apply date range filter if both dates provided
            if ($startDate && $endDate) {
                $query->whereBetween(DB::raw('DATE(return_items.Return_Date)'), [$startDate, $endDate]);
            } elseif ($startDate) {
                // Only start date provided
                $query->whereDate('return_items.Return_Date', '>=', $startDate);
            } elseif ($endDate) {
                // Only end date provided
                $query->whereDate('return_items.Return_Date', '<=', $endDate);
            }

            // Apply cashier filter if provided
            if ($cashierId) {
                $query->where('return_items.Casher_id', $cashierId);
            }

            // Apply reason filter if provided
            if ($reason) {
                switch ($reason) {
                    case 'damaged':
                        $query->where(function($q) {
                            $q->where('return_items.Return_Cause', 'LIKE', '%شکاو%')
                              ->orWhere('return_items.Return_Cause', 'LIKE', '%زیان%')
                              ->orWhere('return_items.Return_Cause', 'LIKE', '%damaged%');
                        });
                        break;
                    case 'defective':
                        $query->where(function($q) {
                            $q->where('return_items.Return_Cause', 'LIKE', '%تێکچو%')
                              ->orWhere('return_items.Return_Cause', 'LIKE', '%کار ناکات%')
                              ->orWhere('return_items.Return_Cause', 'LIKE', '%defective%');
                        });
                        break;
                    case 'exchange':
                        $query->where(function($q) {
                            $q->where('return_items.Return_Cause', 'LIKE', '%گۆڕین%')
                              ->orWhere('return_items.Return_Cause', 'LIKE', '%exchange%');
                        });
                        break;
                    case 'other':
                        $query->where(function($q) {
                            $q->where('return_items.Return_Cause', 'NOT LIKE', '%شکاو%')
                              ->where('return_items.Return_Cause', 'NOT LIKE', '%زیان%')
                              ->where('return_items.Return_Cause', 'NOT LIKE', '%تێکچو%')
                              ->where('return_items.Return_Cause', 'NOT LIKE', '%کار ناکات%')
                              ->where('return_items.Return_Cause', 'NOT LIKE', '%گۆڕین%')
                              ->where('return_items.Return_Cause', 'NOT LIKE', '%damaged%')
                              ->where('return_items.Return_Cause', 'NOT LIKE', '%defective%')
                              ->where('return_items.Return_Cause', 'NOT LIKE', '%exchange%')
                              ->orWhereNull('return_items.Return_Cause')
                              ->orWhere('return_items.Return_Cause', '=', '');
                        });
                        break;
                }
            }

            $returns = $query->orderBy('return_items.created_at', 'desc')->get();

            // Get product names for each return item
            $returns = $returns->map(function ($return) {
                // Try to get product name from products table using Item_Code (barcode)
                $product = DB::table('products')
                    ->where('id', $return->Item_Code)
                    ->select('name', 'barcode')
                    ->first();

                // If not found by barcode, try sale_items
                if (!$product && $return->seles_id) {
                    $saleItem = DB::table('sale_items')
                        ->where('sale_id', $return->seles_id)
                        ->where(function($q) use ($return) {
                            $q->where('product_id', $return->Item_Code)
                              ->orWhere('product_name', 'LIKE', '%' . $return->Item_Code . '%');
                        })
                        ->select('product_name')
                        ->first();
                    
                    if ($saleItem) {
                        $return->product_name = $saleItem->product_name;
                    }
                }

                // Set product name if found
                if ($product && !isset($return->product_name)) {
                    $return->product_name = $product->name;
                }

                // Fallback: use Item_Code as product name
                if (!isset($return->product_name) || empty($return->product_name)) {
                    $return->product_name = $return->Item_Code;
                }

                return $return;
            });

            // Calculate totals
            $totals = [
                'total_amount' => $returns->sum('Return_Total'),
                'total_count' => $returns->count(),
                'total_quantity' => $returns->sum('Amount'),
                'total_by_reason' => [
                    'damaged' => $returns->where('reason_code', 'damaged')->sum('Return_Total'),
                    'defective' => $returns->where('reason_code', 'defective')->sum('Return_Total'),
                    'exchange' => $returns->where('reason_code', 'exchange')->sum('Return_Total'),
                    'other' => $returns->where('reason_code', 'other')->sum('Return_Total'),
                ]
            ];

            return response()->json([
                'success' => true,
                'returns' => $returns,
                'totals' => $totals,
                'filters' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'cashier_id' => $cashierId,
                    'reason' => $reason
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in returnsReport: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error loading returns report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get return details for a specific return item
     */
    public function returnDetail($id)
    {
        try {
            $returnItem = DB::table('return_items')
                ->leftJoin('sales', 'return_items.seles_id', '=', 'sales.id')
                ->leftJoin('users', 'return_items.Casher_id', '=', 'users.id')
                ->where('return_items.id', $id)
                ->select(
                    'return_items.*',
                    'sales.invoice_number',
                    'sales.total as invoice_total',
                    'sales.discount as invoice_discount',
                    'sales.subtotal as invoice_subtotal',
                    'users.name as cashier_name'
                )
                ->first();

            if (!$returnItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Return item not found'
                ], 404);
            }

            // Get product info
            $product = DB::table('products')
                ->where('barcode', $returnItem->Item_Code)
                ->first();

            if ($product) {
                $returnItem->product_name = $product->name;
                $returnItem->product_barcode = $product->barcode;
                $returnItem->product_purchase_price = $product->purchase_price;
                $returnItem->product_selling_price = $product->selling_price;
            }

            // Get the original sale items for this invoice
            if ($returnItem->seles_id) {
                $saleItems = DB::table('sale_items')
                    ->where('sale_id', $returnItem->seles_id)
                    ->get();
                $returnItem->sale_items = $saleItems;
            }

            return response()->json([
                'success' => true,
                'return_item' => $returnItem
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading return detail: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export returns report as CSV (optional feature)
     */
    public function exportReturnsReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $cashierId = $request->input('cashier_id');
            $reason = $request->input('reason');

            $query = DB::table('return_items')
                ->leftJoin('sales', 'return_items.seles_id', '=', 'sales.id')
                ->leftJoin('users', 'return_items.Casher_id', '=', 'users.id')
                ->select(
                    'return_items.id',
                    'sales.invoice_number',
                    'users.name as cashier_name',
                    'return_items.Item_Code',
                    'return_items.Amount',
                    'return_items.Sale_Price',
                    'return_items.Return_Total',
                    'return_items.Return_Cause',
                    'return_items.Return_Date'
                );

            if ($startDate && $endDate) {
                $query->whereBetween(DB::raw('DATE(return_items.Return_Date)'), [$startDate, $endDate]);
            }

            if ($cashierId) {
                $query->where('return_items.Casher_id', $cashierId);
            }

            if ($reason) {
                // Apply same reason filter logic as returnsReport
                switch ($reason) {
                    case 'damaged':
                        $query->where('return_items.Return_Cause', 'LIKE', '%شکاو%')
                              ->orWhere('return_items.Return_Cause', 'LIKE', '%damaged%');
                        break;
                    case 'defective':
                        $query->where('return_items.Return_Cause', 'LIKE', '%تێکچو%')
                              ->orWhere('return_items.Return_Cause', 'LIKE', '%defective%');
                        break;
                    case 'exchange':
                        $query->where('return_items.Return_Cause', 'LIKE', '%گۆڕین%')
                              ->orWhere('return_items.Return_Cause', 'LIKE', '%exchange%');
                        break;
                }
            }

            $returns = $query->orderBy('return_items.created_at', 'desc')->get();

            // Create CSV
            $filename = 'returns_report_' . date('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Transfer-Encoding' => 'binary',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'public'
            ];

            $columns = ['ID', 'Invoice Number', 'Cashier', 'Item Code', 'Amount', 'Sale Price', 'Return Total', 'Return Cause', 'Return Date'];
            
            $callback = function() use ($returns, $columns) {
                $file = fopen('php://output', 'w');
                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                fputcsv($file, $columns);
                
                foreach ($returns as $return) {
                    fputcsv($file, [
                        $return->id,
                        $return->invoice_number,
                        $return->cashier_name,
                        $return->Item_Code,
                        $return->Amount,
                        $return->Sale_Price,
                        $return->Return_Total,
                        $return->Return_Cause,
                        $return->Return_Date
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exporting returns: ' . $e->getMessage()
            ], 500);
        }
    }
}