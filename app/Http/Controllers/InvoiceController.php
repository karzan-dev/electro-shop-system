<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Get invoices with filtering options
     */
    public function getInvoices(Request $request)
    {
        try {
            $filter = $request->input('filter', 'all');
            $timeFilter = $request->input('time_filter', 'all');
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $search = $request->input('search');
            $barcodeSearch = $request->input('barcode');

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
                    'sales.updated_at',

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

            // Payment Type Filter
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

            // Search by barcode
            if ($barcodeSearch) {
                $productIds = DB::table('products')
                    ->where('barcode', 'like', "%$barcodeSearch%")
                    ->pluck('id')
                    ->toArray();

                $saleIdsWithBarcode = DB::table('sale_items')
                    ->whereIn('product_id', $productIds)
                    ->pluck('sale_id')
                    ->unique()
                    ->toArray();

                if (!empty($saleIdsWithBarcode)) {
                    $query->whereIn('sales.id', $saleIdsWithBarcode);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }

            // Time of Day Filter
            if ($timeFilter !== 'all') {
                switch ($timeFilter) {
                    case 'morning':
                        $query->whereRaw('HOUR(sales.created_at) >= 6 AND HOUR(sales.created_at) < 12');
                        break;
                    case 'afternoon':
                        $query->whereRaw('HOUR(sales.created_at) >= 12 AND HOUR(sales.created_at) < 18');
                        break;
                    case 'night':
                        $query->whereRaw('HOUR(sales.created_at) >= 18 OR HOUR(sales.created_at) < 6');
                        break;
                }
            }

            $invoices = $query->get();

            $formattedInvoices = $invoices->map(function($invoice) {
                $timeOfDay = $this->getTimeOfDay($invoice->created_at);

                // ⭐⭐⭐ Sale items with company via JOIN
                $items = DB::table('sale_items')
                    ->leftJoin('products', 'sale_items.product_id', '=', 'products.id')
                    ->leftJoin('companies', 'companies.id', '=', 'products.company_id')  // ⭐ JOIN
                    ->where('sale_items.sale_id', $invoice->id)
                    ->select(
                        'sale_items.id',
                        'sale_items.product_id',
                        'sale_items.product_name as name',
                        'products.barcode',
                        'companies.company_name as company',  // ⭐ لە companies
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
                        'id', 'Item_Code', 'Amount', 'Metar', 'Sale_Price', 'Return_Total',
                        'Return_Cause', 'Casher_id', 'Return_Date', 'created_at', 'updated_at'
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
                        'company' => $item->company ?? 'بێ کۆمپانیا',  // ⭐
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
     */
    private function getTimeOfDay($datetime)
    {
        if (!$datetime) {
            return 'unknown';
        }

        $hour = date('H', strtotime($datetime));

        if ($hour >= 6 && $hour < 12) {
            return 'morning';
        } elseif ($hour >= 12 && $hour < 18) {
            return 'afternoon';
        } else {
            return 'night';
        }
    }

    /**
     * Search invoices by barcode
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

            $product = DB::table('products')
                ->leftJoin('companies', 'companies.id', '=', 'products.company_id')  // ⭐ JOIN
                ->where('barcode', $barcode)
                ->orWhere('barcode', 'like', "%$barcode%")
                ->select(
                    'products.id',
                    'products.name',
                    'products.barcode',
                    'companies.company_name as company'  // ⭐
                )
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => true,
                    'invoices' => [],
                    'message' => 'No product found with this barcode',
                    'total' => 0
                ]);
            }

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

            $invoices = DB::table('sales')
                ->whereIn('id', $saleIds)
                ->orderBy('created_at', 'desc')
                ->get();

            $formattedInvoices = $invoices->map(function($invoice) use ($product) {
                // ⭐ Sale items with company via JOIN
                $items = DB::table('sale_items')
                    ->leftJoin('products', 'sale_items.product_id', '=', 'products.id')
                    ->leftJoin('companies', 'companies.id', '=', 'products.company_id')  // ⭐ JOIN
                    ->where('sale_items.sale_id', $invoice->id)
                    ->select(
                        'sale_items.id',
                        'sale_items.product_id',
                        'sale_items.product_name as name',
                        'products.barcode',
                        'companies.company_name as company',  // ⭐
                        'sale_items.quantity as quantity_sold',
                        'sale_items.selling_price',
                        'sale_items.total'
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
                    'product_company' => $product->company ?? 'بێ کۆمپانیا',  // ⭐
                    'items' => $items->map(fn($item) => [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'name' => $item->name,
                        'barcode' => $item->barcode ?? '',
                        'company' => $item->company ?? 'بێ کۆمپانیا',  // ⭐
                        'quantity_sold' => (float) $item->quantity_sold,
                        'selling_price' => (float) $item->selling_price,
                        'total' => (float) $item->total
                    ])
                ];
            });

            return response()->json([
                'success' => true,
                'invoices' => $formattedInvoices,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'barcode' => $product->barcode,
                    'company' => $product->company ?? 'بێ کۆمپانیا'  // ⭐
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

            // ⭐ ITEMS with company via JOIN
            $items = DB::table('sale_items')
                ->leftJoin('products', 'sale_items.product_id', '=', 'products.id')
                ->leftJoin('companies', 'companies.id', '=', 'products.company_id')  // ⭐ JOIN
                ->where('sale_items.sale_id', $invoice->id)
                ->select(
                    'sale_items.id',
                    'sale_items.product_id',
                    'sale_items.product_name as name',
                    'products.barcode',
                    'companies.company_name as company',  // ⭐
                    'sale_items.purchase_price',
                    'sale_items.selling_price',
                    'sale_items.quantity as quantity_sold',
                    'sale_items.total'
                )
                ->get();

            // CHECK RETURN ITEMS with company
            $returnItems = DB::table('return_items')
                ->leftJoin('products', 'return_items.Item_Code', '=', 'products.id')
                ->leftJoin('companies', 'companies.id', '=', 'products.company_id')  // ⭐ JOIN
                ->where('return_items.seles_id', $invoice->id)
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
                    'products.name as product_name',
                    'companies.company_name as product_company'  // ⭐
                )
                ->get();

            $isReturned = $returnItems->count() > 0;
            $isCredit = !is_null($invoice->loan_id);

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

                    'is_returned' => $isReturned,
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
                        'updated_at' => $ret->updated_at,
                        'product_name' => $ret->product_name ?? '',
                        'product_company' => $ret->product_company ?? 'بێ کۆمپانیا'  // ⭐
                    ]),

                    // ⭐ ITEMS with company
                    'items' => $items->map(fn($item) => [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'name' => $item->name,
                        'barcode' => $item->barcode ?? '',
                        'company' => $item->company ?? 'بێ کۆمپانیا',  // ⭐
                        'purchase_price' => (float) $item->purchase_price,
                        'selling_price' => (float) $item->selling_price,
                        'quantity_sold' => (float) $item->quantity_sold,
                        'total' => (float) $item->total
                    ])
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
     * Delete invoice
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

            $invoice = DB::table('sales')->where('id', $invoiceId)->first();
            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }

            DB::beginTransaction();

            try {
                DB::table('loans')->where('sels_id', $invoiceId)->delete();
                DB::table('sale_items')->where('sale_id', $invoiceId)->delete();
                DB::table('sales')->where('id', $invoiceId)->delete();

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
     */
    public function getInvoiceStats(Request $request)
    {
        try {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');

            $salesQuery = DB::table('sales');

            $cashQuery = DB::table('sales')
                ->leftJoin('loans', 'sales.id', '=', 'loans.sels_id')
                ->whereNull('loans.id');

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
                'morning' => ['count' => 0, 'total_amount' => 0, 'invoices' => []],
                'afternoon' => ['count' => 0, 'total_amount' => 0, 'invoices' => []],
                'night' => ['count' => 0, 'total_amount' => 0, 'invoices' => []]
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