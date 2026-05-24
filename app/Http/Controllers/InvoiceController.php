<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Get invoices with filtering options
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoices(Request $request)
    {
        try {
            $filter = $request->input('filter', 'all');
            $timeFilter = $request->input('time_filter', 'all');
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $search = $request->input('search'); // Search by invoice number
            $barcodeSearch = $request->input('barcode'); // Search by barcode

            // Base query: sales join loans
         $query = DB::table('sales')
    ->leftJoin('loans', 'sales.invoice_number', '=', 'loans.invoice_number')
    ->leftJoin('customer', 'customer.id', '=', 'loans.customer_id') 
    ->leftJoin('users', 'sales.user_id', '=', 'users.id') 
    ->select(
        'sales.id',
        'sales.invoice_number',
        'sales.user_id',
        'sales.subtotal',
        'sales.discount',
        'sales.total',
        'sales.created_at',
        "sales.updated_at",

        'loans.id as loan_id',
        'loans.currency',
        'loans.period',
        'loans.total as loan_total',
        'loans.status as loan_status',
        'loans.time_to_return',

        'customer.name as customer_name',
        'customer.number_phone as phone_number',
        'customer.address',

        'users.name as user_name'
    )
    ->orderBy('sales.created_at', 'desc');

            // Payment Type Filter (cash/credit)
            if ($filter === 'cash') {
                $query->whereNull('loans.id');
            }
            if ($filter === 'credit') {
                $query->whereNotNull('loans.id');
            }
            
            // Date Range Filter
            if ($fromDate) {
                $query->whereDate('sales.created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('sales.created_at', '<=', $toDate);
            }
            
            // Search by invoice number
            if ($search) {
                $query->where('sales.invoice_number', 'like', "%$search%");
            }
            
            // Search by barcode - NEW FEATURE
            if ($barcodeSearch) {
                // First find product IDs by barcode from products table
                $productIds = DB::table('products')
                    ->where('barcode', 'like', "%$barcodeSearch%")
                    ->pluck('id')
                    ->toArray();
                
                // Then find sale items that have these product IDs
                $saleIdsWithBarcode = DB::table('sale_items')
                    ->whereIn('product_id', $productIds)
                    ->pluck('sale_id')
                    ->unique()
                    ->toArray();
                
                if (!empty($saleIdsWithBarcode)) {
                    $query->whereIn('sales.id', $saleIdsWithBarcode);
                } else {
                    // If no matching barcode found, return empty result
                    $query->whereRaw('1 = 0');
                }
            }
            
            // Time of Day Filter (Morning/Afternoon/Night)
            if ($timeFilter !== 'all') {
                switch ($timeFilter) {
                    case 'morning':
                        // Morning: 6:00 AM to 11:59 AM
                        $query->whereRaw('HOUR(sales.created_at) >= 6 AND HOUR(sales.created_at) < 12');
                        break;
                    case 'afternoon':
                        // Afternoon: 12:00 PM to 5:59 PM
                        $query->whereRaw('HOUR(sales.created_at) >= 12 AND HOUR(sales.created_at) < 18');
                        break;
                    case 'night':
                        // Night: 6:00 PM to 5:59 AM (next day)
                        $query->whereRaw('HOUR(sales.created_at) >= 18 OR HOUR(sales.created_at) < 6');
                        break;
                    default:
                        // No filter
                        break;
                }
            }

            $invoices = $query->get();

            $formattedInvoices = $invoices->map(function($invoice) {
                // Get time of day for each invoice
                $timeOfDay = $this->getTimeOfDay($invoice->created_at);
                
                // Sale items with product details including barcode
                $items = DB::table('sale_items')
                    ->leftJoin('products', 'sale_items.product_id', '=', 'products.id')
                    ->where('sale_items.sale_id', $invoice->id)
                    ->select(
                        'sale_items.id',
                        'sale_items.product_id',
                        'sale_items.product_name as name',
                        'products.barcode',
                        'sale_items.purchase_price',
                        'sale_items.selling_price',
                        'sale_items.quantity as quantity_sold',
                        'sale_items.total'
                    )
                    ->get();

                // Return items
                $returnItems = DB::table('return_items')
                    ->where('Item_Code', $invoice->id)
                    ->select(
                        'id','Item_Code','Amount','Metar','Sale_Price','Return_Total','Return_Cause','Casher_id','Return_Date','created_at','updated_at'
                    )
                    ->get();

                $isCredit = !is_null($invoice->loan_id);

                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'user_id' => $invoice->user_id,
                    'subtotal' => (float) $invoice->subtotal,
                    'discount' => (float) $invoice->discount,
                    'total' => (float) $invoice->total,
                    'created_at' => $invoice->created_at,
                    'updated_at' => $invoice->updated_at,
                    'time_of_day' => $timeOfDay,
                    'hour' => date('H', strtotime($invoice->created_at)),
                    'is_credit' => $isCredit,
                    'credit_info' => $isCredit ? [
                        'customer_name' => $invoice->customer_name,
                        'phone_number' => $invoice->phone_number,
                        'address' => $invoice->address,
                        'currency' => $invoice->currency,
                        'period' => $invoice->period,
                        'time_to_return' => $invoice->time_to_return,
                        'status' => $invoice->loan_status,
                        'loan_total' => (float) ($invoice->loan_total ?? $invoice->total)
                    ] : null,
                    'items' => $items->map(fn($item) => [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'name' => $item->name,
                        'barcode' => $item->barcode ?? '',
                        'quantity_sold' => (float) $item->quantity_sold,
                        'selling_price' => (float) $item->selling_price,
                        'purchase_price' => (float) $item->purchase_price,
                        'total' => (float) $item->total
                    ]),
                    'return_items' => $returnItems->map(fn($ret) => [
                        'id' => $ret->id,
                        'Item_Code' => $ret->Item_Code,
                        'Amount' => (float) $ret->Amount,
                        'Metar' => $ret->Metar,
                        'Sale_Price' => (float) $ret->Sale_Price,
                        'Return_Total' => (float) $ret->Return_Total,
                        'Return_Cause' => $ret->Return_Cause,
                        'Casher_id' => $ret->Casher_id,
                        'Return_Date' => $ret->Return_Date,
                        'created_at' => $ret->created_at,
                        'updated_at' => $ret->updated_at
                    ])
                ];
            });

            return response()->json([
                'success' => true,
                'invoices' => $formattedInvoices,
                'total' => $formattedInvoices->count(),
                'filters' => [
                    'payment_type' => $filter,
                    'time_filter' => $timeFilter,
                    'date_from' => $fromDate,
                    'date_to' => $toDate,
                    'search' => $search,
                    'barcode' => $barcodeSearch
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getInvoices: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching invoices',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get time of day based on hour
     * 
     * @param string $datetime
     * @return string
     */
    private function getTimeOfDay($datetime)
    {
        if (!$datetime) {
            return 'unknown';
        }
        
        $hour = date('H', strtotime($datetime));
        
        if ($hour >= 6 && $hour < 12) {
            return 'morning'; // بەیانی 6-12
        } elseif ($hour >= 12 && $hour < 18) {
            return 'afternoon'; // ئێوارە 12-18
        } else {
            return 'night'; // شەو 18-6
        }
    }

    /**
     * Search invoices by barcode (dedicated endpoint)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchInvoicesByBarcode(Request $request)
    {
        try {
            $barcode = $request->input('barcode');
            
            if (!$barcode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barcode is required'
                ], 400);
            }
            
            // Find product by barcode
            $product = DB::table('products')
                ->where('barcode', $barcode)
                ->orWhere('barcode', 'like', "%$barcode%")
                ->first();
            
            if (!$product) {
                return response()->json([
                    'success' => true,
                    'invoices' => [],
                    'message' => 'No product found with this barcode',
                    'total' => 0
                ]);
            }
            
            // Find all sale items with this product
            $saleIds = DB::table('sale_items')
                ->where('product_id', $product->id)
                ->pluck('sale_id')
                ->unique()
                ->toArray();
            
            if (empty($saleIds)) {
                return response()->json([
                    'success' => true,
                    'invoices' => [],
                    'message' => 'No invoices found for this product',
                    'total' => 0
                ]);
            }
            
            // Get invoices with these sale IDs
            $invoices = DB::table('sales')
                ->whereIn('id', $saleIds)
                ->orderBy('created_at', 'desc')
                ->get();
            
            $formattedInvoices = $invoices->map(function($invoice) use ($product) {
                // Get items for this invoice
                $items = DB::table('sale_items')
                    ->where('sale_id', $invoice->id)
                    ->select(
                        'id',
                        'product_id',
                        'product_name as name',
                        'quantity as quantity_sold',
                        'selling_price',
                        'total'
                    )
                    ->get();
                
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'subtotal' => (float) $invoice->subtotal,
                    'discount' => (float) $invoice->discount,
                    'total' => (float) $invoice->total,
                    'created_at' => $invoice->created_at,
                    'product_name' => $product->name,
                    'product_barcode' => $product->barcode,
                    'items' => $items
                ];
            });
            
            return response()->json([
                'success' => true,
                'invoices' => $formattedInvoices,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'barcode' => $product->barcode
                ],
                'total' => $formattedInvoices->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in searchInvoicesByBarcode: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching by barcode',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get single invoice details
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
public function getInvoice($id)
{
    try {
$invoice = DB::table('sales')
    ->leftJoin('loans', 'sales.invoice_number', '=', 'loans.invoice_number')
    ->leftJoin('customer', 'customer.id', '=', 'loans.customer_id')
    ->where('sales.id', $id)
    ->select(
        'sales.id',
        'sales.invoice_number',
        'sales.user_id',
        'sales.subtotal',
        'sales.discount',
        'sales.total',
        'sales.created_at',
        'sales.updated_at',

        'loans.id as loan_id',
        'customer.name as customer_name',
        'customer.number_phone as phone_number',
        'customer.address as address',
        'loans.currency',
        'loans.period',
        'loans.total as loan_total',
        'loans.status as loan_status',
        'loans.time_to_return'
    )
    ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found'
            ], 404);
        }

        // ITEMS
        $items = DB::table('sale_items')
            ->leftJoin('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sale_items.sale_id', $invoice->id)
            ->select(
                'sale_items.id',
                'sale_items.product_id',
                'sale_items.product_name as name',
                'products.barcode',
                'sale_items.purchase_price',
                'sale_items.selling_price',
                'sale_items.quantity as quantity_sold',
                'sale_items.total'
            )
            ->get();

        // CHECK CREDIT
        $isCredit = !is_null($invoice->loan_id);

        // SAFE CREDIT INFO
        $creditInfo = $isCredit ? [
            'customer_name' => $invoice->customer_name ?? '',
            'phone_number' => $invoice->phone_number ?? '',
            'address' => $invoice->address ?? '',
            'currency' => $invoice->currency ?? '',
            'period' => $invoice->period ?? '',
            'time_to_return' => $invoice->time_to_return ?? '',
            'status' => $invoice->loan_status ?? null,
            'loan_total' => (float) ($invoice->loan_total ?? 0)
        ] : null;

        // RESPONSE
        return response()->json([
            'success' => true,
            'invoice' => [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'user_id' => $invoice->user_id,
                'subtotal' => (float) $invoice->subtotal,
                'discount' => (float) $invoice->discount,
                'total' => (float) $invoice->total,
                'created_at' => $invoice->created_at,
                'updated_at' => $invoice->updated_at,

                'is_credit' => $isCredit,
                'credit_info' => $creditInfo,

                'items' => $items
            ]
        ], 200);

    } catch (\Exception $e) {

        Log::error('Error in getInvoice: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while fetching invoice details',
            'error' => $e->getMessage()
        ], 500);
    }
}
    /**
     * Delete invoice and associated loan and items
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteInvoice(Request $request)
    {
        try {
            $invoiceId = $request->input('invoice_id');
            
            if (!$invoiceId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice ID is required'
                ], 400);
            }
            
            // Check if invoice exists
            $invoice = DB::table('sales')->where('id', $invoiceId)->first();
            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }
            
            // Start a database transaction
            DB::beginTransaction();
            
            try {
                // Delete loan record if exists (using sels_id)
                DB::table('loans')->where('sels_id', $invoiceId)->delete();
                
                // Delete invoice items from sale_items table
                DB::table('sale_items')->where('sale_id', $invoiceId)->delete();
                
                // Delete the invoice from sales table
                DB::table('sales')->where('id', $invoiceId)->delete();
                
                // Commit transaction
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice and all associated data deleted successfully'
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            Log::error('Error in deleteInvoice: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get invoice statistics
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceStats(Request $request)
    {
        try {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            
            // Base query for sales
            $salesQuery = DB::table('sales');
            
            // Cash invoices (no loan)
            $cashQuery = DB::table('sales')
                ->leftJoin('loans', 'sales.id', '=', 'loans.sels_id')
                ->whereNull('loans.id');
            
            // Credit invoices (has loan)
            $creditQuery = DB::table('sales')
                ->join('loans', 'sales.id', '=', 'loans.sels_id');
            
            if ($fromDate) {
                $salesQuery->whereDate('created_at', '>=', $fromDate);
                $cashQuery->whereDate('sales.created_at', '>=', $fromDate);
                $creditQuery->whereDate('sales.created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $salesQuery->whereDate('created_at', '<=', $toDate);
                $cashQuery->whereDate('sales.created_at', '<=', $toDate);
                $creditQuery->whereDate('sales.created_at', '<=', $toDate);
            }
            
            // Get statistics
            $totalInvoices = $salesQuery->count();
            $totalSales = (float) $salesQuery->sum('total');
            $cashCount = $cashQuery->count();
            $creditCount = $creditQuery->count();
            $cashTotal = (float) $cashQuery->sum('sales.total');
            $creditTotal = (float) $creditQuery->sum('sales.total');
            
            return response()->json([
                'success' => true,
                'stats' => [
                    'total_invoices' => $totalInvoices,
                    'total_sales' => $totalSales,
                    'cash_invoices' => $cashCount,
                    'credit_invoices' => $creditCount,
                    'cash_total' => $cashTotal,
                    'credit_total' => $creditTotal
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in getInvoiceStats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get statistics by time of day
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceStatsByTime(Request $request)
    {
        try {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            
            $query = DB::table('sales');
            
            if ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            }
            
            $invoices = $query->get();
            
            $stats = [
                'morning' => [
                    'count' => 0,
                    'total_amount' => 0,
                    'invoices' => []
                ],
                'afternoon' => [
                    'count' => 0,
                    'total_amount' => 0,
                    'invoices' => []
                ],
                'night' => [
                    'count' => 0,
                    'total_amount' => 0,
                    'invoices' => []
                ]
            ];
            
            foreach ($invoices as $invoice) {
                $timeOfDay = $this->getTimeOfDay($invoice->created_at);
                $stats[$timeOfDay]['count']++;
                $stats[$timeOfDay]['total_amount'] += (float) $invoice->total;
                
                if (count($stats[$timeOfDay]['invoices']) < 10) {
                    $stats[$timeOfDay]['invoices'][] = [
                        'invoice_number' => $invoice->invoice_number,
                        'total' => (float) $invoice->total,
                        'created_at' => $invoice->created_at
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'statistics' => $stats,
                'total_invoices' => $invoices->count(),
                'total_amount' => (float) $invoices->sum('total')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in getInvoiceStatsByTime: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}