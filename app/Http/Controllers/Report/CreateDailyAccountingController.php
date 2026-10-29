<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class CreateDailyAccountingController extends Controller
{
    /**
     * Get all cashiers (users with role 'Casher')
     */
    public function getData()
    {
        try {
            $users = DB::table('users')
                ->where('role', '2')
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading cashiers: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cashier details with daily summary
     */
    public function getDetails($id)
    {
        try {
            // Get cashier info
            $cashier = DB::table('users')
                ->where('id', $id)
                ->where('role', '2')
                ->select('id', 'name')
                ->first();

            if (!$cashier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cashier not found'
                ], 404);
            }

            // Get today's date
            $today = now()->format('Y-m-d');
            
            // Get today's sales summary
            $todaySales = DB::table('sales')
                ->where('user_id', $id)
                ->whereDate('created_at', $today)
                ->select(
                    DB::raw('COUNT(*) as invoice_count'),
                    DB::raw('COALESCE(SUM(total), 0) as total_sales'),
                    DB::raw('COALESCE(SUM(discount), 0) as total_discount'),
                    DB::raw('COALESCE(SUM(subtotal), 0) as subtotal')
                )
                ->first();

            // Get today's returns
            $todayReturns = DB::table('return_items')
                ->where('Casher_id', $id)
                ->whereDate('Return_Date', $today)
                ->select(
                    DB::raw('COALESCE(SUM(Return_Total), 0) as total_returns'),
                    DB::raw('COUNT(*) as return_count')
                )
                ->first();

            // Get casher_coin for today
            $casherCoin = DB::table('casher_coin')
                ->where('casher_id', $id)
                ->whereDate('created_at', $today)
                ->select(
                    DB::raw('COALESCE(SUM(amount), 0) as total_amount'),
                    DB::raw('COUNT(*) as transaction_count')
                )
                ->first();

            // Get last casher_coin record
            $lastCoinTransaction = DB::table('casher_coin')
                ->where('casher_id', $id)
                ->orderBy('created_at', 'desc')
                ->first();

            return response()->json([
                'success' => true,
                'name' => $cashier->name,
                'today_sales' => $todaySales->total_sales ?? 0,
                'today_discount' => $todaySales->total_discount ?? 0,
                'today_subtotal' => $todaySales->subtotal ?? 0,
                'invoice_count' => $todaySales->invoice_count ?? 0,
                'total_returns' => $todayReturns->total_returns ?? 0,
                'return_count' => $todayReturns->return_count ?? 0,
                'casher_coin_total' => $casherCoin->total_amount ?? 0,
                'casher_coin_transactions' => $casherCoin->transaction_count ?? 0,
                'last_coin_transaction' => $lastCoinTransaction ? [
                    'amount' => $lastCoinTransaction->amount,
                    'date' => $lastCoinTransaction->created_at
                ] : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading cashier details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get invoices - can filter by date only or date + cashier
     * If only date is provided, get all cashiers' invoices for that date
     * If cashier_id is also provided, filter by cashier too
     */
public function getInvoices(Request $request)
{
    try {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $date = $request->input('date');
        $cashierId = $request->input('cashier_id');
        
        // ============================================
        // 1. GET SALES (فرۆشتنەکان)
        // ============================================
        $salesQuery = DB::table('sales')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->select(
                'sales.id',
                'sales.invoice_number',
                'sales.user_id',
                'users.name as cashier_name',
                'sales.total as total_sales',
                'sales.discount as total_discount',
                'sales.subtotal',
                'sales.created_at as date',
                DB::raw('DATE(sales.created_at) as accountingDate'),
                DB::raw("'sales' as source_type"),
                DB::raw("'فرۆشتن' as action_type"),
                DB::raw("NULL as seles_id"),
                DB::raw("NULL as Item_Code"),
                DB::raw("NULL as Item_Name"),
                DB::raw("NULL as Amount"),
                DB::raw("NULL as Metar"),
                DB::raw("NULL as Sale_Price"),
                DB::raw("NULL as Return_Total"),
                DB::raw("NULL as Return_Cause"),
                DB::raw("NULL as Return_Date")
            );

        if ($startDate && $endDate) {
            $salesQuery->whereBetween(DB::raw('DATE(sales.created_at)'), [$startDate, $endDate]);
        } elseif ($date) {
            $salesQuery->whereDate('sales.created_at', $date);
        }

        if ($cashierId) {
            $salesQuery->where('sales.user_id', $cashierId);
        }

        // ============================================
        // 2. GET INDEPENDENT RETURNS (گەڕاوە سەربەخۆکان) - ✅ ناوی کاڵا زیاد کرا
        // ============================================
        $returnsQuery = DB::table('return_items')
            ->leftJoin('users', 'return_items.Casher_id', '=', 'users.id')
            ->leftJoin('sales', 'return_items.seles_id', '=', 'sales.id')
            ->leftJoin('products', 'return_items.Item_Code', '=', 'products.id')
            ->select(
                'return_items.id',
                DB::raw("COALESCE(sales.invoice_number, CONCAT('RET-', return_items.id)) as invoice_number"),
                'return_items.Casher_id as user_id',
                DB::raw("COALESCE(users.name, 'نەناسراو') as cashier_name"),
                DB::raw("return_items.Return_Total as total_sales"),
                DB::raw("0 as total_discount"),
                DB::raw("return_items.Return_Total as subtotal"),
                'return_items.created_at as date',
                DB::raw('DATE(return_items.created_at) as accountingDate'),
                DB::raw("'return' as source_type"),
                DB::raw("'گەڕاوە' as action_type"),
                'return_items.seles_id',
                'return_items.Item_Code',
                'products.name as Item_Name',
                'return_items.Amount',
                'return_items.Metar',
                'return_items.Sale_Price',
                'return_items.Return_Total as return_total_value',
                'return_items.Return_Cause',
                'return_items.Return_Date'
            );

        if ($startDate && $endDate) {
            $returnsQuery->whereBetween(DB::raw('DATE(return_items.created_at)'), [$startDate, $endDate]);
        } elseif ($date) {
            $returnsQuery->whereDate('return_items.created_at', $date);
        }

        if ($cashierId) {
            $returnsQuery->where('return_items.Casher_id', $cashierId);
        }

        // ============================================
        // 3. COMBINE BOTH QUERIES WITH UNION ALL
        // ============================================
        $combinedQuery = $salesQuery->unionAll($returnsQuery);
        $combinedResults = $combinedQuery->orderBy('date', 'desc')->get();

        // ============================================
        // 4. PROCESS EACH RECORD
        // ============================================
        $invoicesWithDetails = $combinedResults->map(function ($record) use ($startDate, $endDate, $date) {
            $recordDate = $record->accountingDate;
            $isReturnRecord = ($record->source_type === 'return');
            $saleId = $isReturnRecord ? $record->seles_id : $record->id;
            
            $returnDetails = collect([]);
            $totalReturns = 0;
            $returnCount = 0;
            
            if ($isReturnRecord) {
                $totalReturns = 0;
                $returnCount = 1;
                $returnDetails = collect([
                    [
                        'id' => $record->id,
                        'seles_id' => $record->seles_id,
                        'Item_Code' => $record->Item_Code,
                        'name' => $record->Item_Name ?? 'نەناسراو',
                        'Amount' => $record->Amount,
                        'Metar' => $record->Metar,
                        'Sale_Price' => $record->Sale_Price,
                        'Return_Total' => $record->return_total_value ?? 0,
                        'Return_Cause' => $record->Return_Cause,
                        'Casher_id' => $record->user_id,
                        'Return_Date' => $record->Return_Date,
                    ]
                ]);
            } else {
                $returnsQuery = DB::table('return_items')
                    ->where('seles_id', $record->id);
                
                if ($startDate && $endDate) {
                    $returnsQuery->whereBetween(DB::raw('DATE(Return_Date)'), [$startDate, $endDate]);
                } else {
                    $returnsQuery->whereDate('Return_Date', $recordDate);
                }
                
                $returns = $returnsQuery->select(
                    DB::raw('COALESCE(SUM(Return_Total), 0) as total_returns'),
                    DB::raw('COUNT(*) as return_count')
                )->first();

                $totalReturns = $returns->total_returns ?? 0;
                $returnCount = $returns->return_count ?? 0;
                
                // ✅ ناوی کاڵا زیاد کرا
                $returnDetails = DB::table('return_items')
                    ->leftJoin('products', 'return_items.Item_Code', '=', 'products.id')
                    ->where('return_items.seles_id', $record->id)
                    ->when($startDate && $endDate, function($query) use ($startDate, $endDate) {
                        return $query->whereBetween(DB::raw('DATE(return_items.Return_Date)'), [$startDate, $endDate]);
                    })
                    ->when(!($startDate && $endDate), function($query) use ($recordDate) {
                        return $query->whereDate('return_items.Return_Date', $recordDate);
                    })
                    ->select(
                        'return_items.id',
                        'return_items.seles_id',
                        'return_items.Item_Code',
                        'products.name as name',
                        'return_items.Amount',
                        'return_items.Metar',
                        'return_items.Sale_Price',
                        'return_items.Return_Total',
                        'return_items.Return_Cause',
                        'return_items.Casher_id',
                        'return_items.Return_Date',
                        'return_items.created_at'
                    )
                    ->get();
            }

            // Get casher_coin
            $casherCoinQuery = DB::table('casher_coin')
                ->where('casher_id', $record->user_id);
            
            if ($startDate && $endDate) {
                $casherCoinQuery->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            } else {
                $casherCoinQuery->whereDate('created_at', $recordDate);
            }
            
            $casherCoin = $casherCoinQuery->select(DB::raw('COALESCE(SUM(amount), 0) as total_amount'))->first();

            // Check loans by invoice_number
            $loans = collect([]);
            $totalLoans = 0;
            $isCreditSale = false;
            
            if (!$isReturnRecord) {
                $loans = DB::table('loans')
                    ->where('invoice_number', $record->invoice_number)
                    ->select('id', 'private_goods_id', 'customer_id', 'currency', 'period', 'total', 'status', 'time_to_return', 'created_at')
                    ->get();

                $totalLoans = $loans->sum('total');
                $isCreditSale = $loans->isNotEmpty();
            }

            $casherCoinAmount = $casherCoin->total_amount ?? 0;
            $totalSalesValue = $record->total_sales ?? 0;
            $finalTotal = $isReturnRecord ? -$totalSalesValue : ($totalSalesValue - $totalReturns);
            
            $profit = 0;
            if (!$isReturnRecord && $saleId) {
                $profit = $this->calculateProfit($saleId);
            }
            
            $netBalance = $finalTotal - ($record->total_discount ?? 0) + $casherCoinAmount - $totalLoans;

            if ($netBalance == 0) {
                $status = 'هاوسەنگ';
                $shortAmount = 0;
                $extraAmount = 0;
            } elseif ($netBalance < 0) {
                $status = 'کەم';
                $shortAmount = abs($netBalance);
                $extraAmount = 0;
            } else {
                $status = 'زیاد';
                $shortAmount = 0;
                $extraAmount = $netBalance;
            }

            $saleType = $isCreditSale ? 'فرۆشتنی قەرزە' : 'فرۆشتنی ئاسایی';
            $actionType = $isReturnRecord ? 'گەڕاوە' : 'فرۆشتن';

            return [
                'id' => $record->id,
                'invoice_number' => $record->invoice_number,
                'cashier_id' => $record->user_id,
                'cashierName' => $record->cashier_name,
                'totalSales' => $totalSalesValue,
                'totalReturns' => $totalReturns,
                'returnCount' => $returnCount,
                'totalDiscount' => $record->total_discount ?? 0,
                'casherCoin' => $casherCoinAmount,
                'totalLoans' => $totalLoans,
                'loanCount' => $loans->count(),
                'loans' => $loans,
                'todayProfit' => $profit,
                'accountStatus' => $status,
                'invoice_id' => $record->id,
                'invoice_Number' => $record->invoice_number,
                'shortAmount' => $shortAmount,
                'extraAmount' => $extraAmount,
                'subtotal' => $record->subtotal ?? $totalReturns,
                'accountingDate' => $record->accountingDate,
                'casherCoinAmount' => $casherCoinAmount,
                'date' => $record->date,
                'isCreditSale' => $isCreditSale,
                'saleType' => $saleType,
                'isReturn' => $isReturnRecord,
                'actionType' => $actionType,
                'sourceType' => $record->source_type,
                'returnDetails' => $returnDetails,
            ];
        });

        // ============================================
        // 5. CALCULATE SUMMARY - راستەوخۆ SUM(Return_Total)
        // ============================================
        
        // کۆی فرۆشتنەکان (تەنها سەیڵەکان)
        $totalSalesSum = $invoicesWithDetails->where('isReturn', false)->sum('totalSales');
        
        // راستەوخۆ کۆی Return_Total لە تەیبڵی return_items
        $totalReturnsSum = DB::table('return_items')
            ->when($startDate && $endDate, function($query) use ($startDate, $endDate) {
                return $query->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            })
            ->when($date && !$startDate, function($query) use ($date) {
                return $query->whereDate('created_at', $date);
            })
            ->when($cashierId, function($query) use ($cashierId) {
                return $query->where('Casher_id', $cashierId);
            })
            ->sum('Return_Total');

        return response()->json([
            'success' => true,
            'invoices' => $invoicesWithDetails,
            'summary' => [
                'totalInvoices' => $invoicesWithDetails->count(),
                'totalSales' => $totalSalesSum,
                'totalReturns' => $totalReturnsSum ?? 0,
                'totalDiscount' => $invoicesWithDetails->sum('totalDiscount'),
                'totalLoans' => $invoicesWithDetails->sum('totalLoans'),
            ]
        ]);
    } catch (\Exception $e) {
        Log::error('Error in getInvoices: ' . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error loading invoices: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Get single invoice details
  /**
 * Show invoice/return details
 */
public function show($id)
{
    try {
        // Check if this is a return item request (ID starts with 'RET-' or 'گەڕاوە-')
        if (strpos($id, 'RET-') === 0 || strpos($id, 'گەڕاوە-') === 0) {
            return $this->showReturnItem($id);
        }
        
        // Otherwise, treat it as a sale invoice
        return $this->showSaleInvoice($id);
        
    } catch (\Exception $e) {
        Log::error('Error in show: ' . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'id' => $id
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error loading invoice: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Show sale invoice details
 */
private function showSaleInvoice($id)
{
    // Get sale info
    $sale = DB::table('sales')
        ->join('users', 'sales.user_id', '=', 'users.id')
        ->where('sales.id', $id)
        ->select(
            'sales.*',
            'users.name as cashier_name'
        )
        ->first();

    if (!$sale) {
        // Try to find as return item by numeric ID
        return $this->showReturnItem($id);
    }

    $saleDate = date('Y-m-d', strtotime($sale->created_at));

    // Get sale items
    $items = DB::table('sale_items')
        ->where('sale_id', $id)
        ->select(
            'id',
            'product_name as name',
            'quantity',
            'purchase_price',
            'selling_price as price',
            'total'
        )
        ->get();

    // Get returns for this sale (by seles_id) - JOIN with products table
    $returns = DB::table('return_items')
        ->leftJoin('products', 'return_items.Item_Code', '=', 'products.id')
        ->where('return_items.seles_id', $sale->id)
        ->select(
            'return_items.id',
            'return_items.seles_id',
            'return_items.Item_Code',
            'products.name as Item_Name',
            'return_items.Amount',
            'return_items.Metar',
            'return_items.Sale_Price',
            'return_items.Return_Total',
            'return_items.Return_Cause',
            'return_items.Return_Date',
            'return_items.Casher_id',
            'return_items.created_at'
        )
        ->get();

    // Get casher_coin transactions
    $casherCoins = DB::table('casher_coin')
        ->where('casher_id', $sale->user_id)
        ->whereDate('created_at', $saleDate)
        ->select(
            'id',
            'amount',
            'created_at'
        )
        ->get();

    // Get loans for this sale
    $loans = DB::table('loans')
        ->where(function($query) use ($sale) {
            $query->where('sels_id', $sale->id)
                  ->orWhere('invoice_number', $sale->invoice_number);
        })
        ->select(
            'id',
            'private_goods_id',
            'customer_id',
            'currency',
            'period',
            'total',
            'status',
            'time_to_return',
            'created_at'
        )
        ->get();

    // Calculate profit
    $profit = $this->calculateProfit($id);

    // Get return details text
    $returnDetails = $this->getReturnDetails($sale->user_id, $saleDate);

    return response()->json([
        'success' => true,
        'invoice' => [
            'id' => $sale->id,
            'invoice_number' => $sale->invoice_number,
            'cashier_name' => $sale->cashier_name,
            'cashier_id' => $sale->user_id,
            'date' => $sale->created_at,
            'accountingDate' => $saleDate,
            'total_sales' => $sale->total,
            'total_discount' => $sale->discount,
            'subtotal' => $sale->subtotal,
            'total_returns' => $returns->sum('Return_Total'),
            'return_count' => $returns->count(),
            'casher_coins' => $casherCoins,
            'casher_coin_total' => $casherCoins->sum('amount'),
            'profit' => $profit,
            'todayProfit' => $profit,
            'items' => $items,
            'returns' => $returns,
            'loans' => $loans,
            'total_loans' => $loans->sum('total'),
            'loan_count' => $loans->count(),
            'is_credit_sale' => $loans->isNotEmpty(),
            'sale_type' => $loans->isNotEmpty() ? 'فرۆشتنی قەرزە' : 'فرۆشتنی ئاسایی',
            'action_type' => 'فرۆشتن',
            'source_type' => 'sales',
            'is_return' => false,
            'return_details' => $returnDetails,
        ]
    ]);
}

/**
 * Show return item details
 */
private function showReturnItem($id)
{
    // Remove prefixes if present
    $numericId = str_replace(['RET-', 'گەڕاوە-'], '', $id);
    
    // Get return item with sale invoice_number and product name
    $returnItem = DB::table('return_items')
        ->leftJoin('users', 'return_items.Casher_id', '=', 'users.id')
        ->leftJoin('sales', 'return_items.seles_id', '=', 'sales.id')
        ->leftJoin('products', 'return_items.Item_Code', '=', 'products.id')
        ->where('return_items.id', $numericId)
        ->select(
            'return_items.*',
            'users.name as cashier_name',
            'sales.invoice_number as sale_invoice_number',
            'sales.total as sale_total',
            'sales.created_at as sale_date',
            'products.name as Item_Name'
        )
        ->first();

    if (!$returnItem) {
        return response()->json([
            'success' => false,
            'message' => 'Return item not found'
        ], 404);
    }

    // Determine invoice_number for this return
    $invoiceNumber = $returnItem->sale_invoice_number;

    // Get all return items with the same seles_id - JOIN with products table
    $allRelatedReturns = collect([]);
    if ($returnItem->seles_id) {
        $allRelatedReturns = DB::table('return_items')
            ->leftJoin('products', 'return_items.Item_Code', '=', 'products.id')
            ->where('return_items.seles_id', $returnItem->seles_id)
            ->select(
                'return_items.id',
                'return_items.seles_id',
                'return_items.Item_Code',
                'products.name as Item_Name',
                'return_items.Amount',
                'return_items.Metar',
                'return_items.Sale_Price',
                'return_items.Return_Total',
                'return_items.Return_Cause',
                'return_items.Return_Date',
                'return_items.Casher_id',
                'return_items.created_at'
            )
            ->get();
    }

    // Get casher_coin for this cashier on this date
    $returnDate = date('Y-m-d', strtotime($returnItem->created_at));
    $casherCoins = DB::table('casher_coin')
        ->where('casher_id', $returnItem->Casher_id)
        ->whereDate('created_at', $returnDate)
        ->select('id', 'amount', 'created_at')
        ->get();

    // Get return details text
    $returnDetails = $this->getReturnDetails($returnItem->Casher_id, $returnDate);

    return response()->json([
        'success' => true,
        'invoice' => [
            'id' => $returnItem->id,
            'invoice_number' => $invoiceNumber,
            'cashier_name' => $returnItem->cashier_name ?? 'نەناسراو',
            'cashier_id' => $returnItem->Casher_id,
            'date' => $returnItem->created_at,
            'accountingDate' => $returnDate,
            'total_sales' => 0,
            'total_discount' => 0,
            'subtotal' => $returnItem->Return_Total,
            'total_returns' => $returnItem->Return_Total,
            'return_count' => 1,
            'casher_coins' => $casherCoins,
            'casher_coin_total' => $casherCoins->sum('amount'),
            'profit' => 0,
            'todayProfit' => 0,
            'items' => [],
            'returns' => $allRelatedReturns->isNotEmpty() ? $allRelatedReturns : collect([$returnItem]),
            'loans' => [],
            'total_loans' => 0,
            'loan_count' => 0,
            'is_credit_sale' => false,
            'sale_type' => '---',
            'action_type' => 'گەڕاوە',
            'source_type' => 'return',
            'is_return' => true,
            'return_details' => $returnDetails,
            // وردەکاری گەڕاوە
            'return_item' => [
                'id' => $returnItem->id,
                'seles_id' => $returnItem->seles_id,
                'Item_Code' => $returnItem->Item_Code,
                'Item_Name' => $returnItem->Item_Name,
                'Amount' => $returnItem->Amount,
                'Metar' => $returnItem->Metar,
                'Sale_Price' => $returnItem->Sale_Price,
                'Return_Total' => $returnItem->Return_Total,
                'Return_Cause' => $returnItem->Return_Cause,
                'Return_Date' => $returnItem->Return_Date,
                'Casher_id' => $returnItem->Casher_id,
            ],
            // زانیاری پسوڵەی پەیوەندیدار
            'related_sale' => $returnItem->seles_id ? [
                'id' => $returnItem->seles_id,
                'invoice_number' => $returnItem->sale_invoice_number,
                'total' => $returnItem->sale_total,
                'date' => $returnItem->sale_date,
            ] : null,
        ]
    ]);
}

/**
 * Calculate profit for a sale
 */
private function calculateProfit($saleId)
{
    $items = DB::table('sale_items')
        ->where('sale_id', $saleId)
        ->select(
            DB::raw('COALESCE(SUM((selling_price - purchase_price) * quantity), 0) as total_profit')
        )
        ->first();

    return $items->total_profit ?? 0;
}

/**
 * Get return details as text - ناوی کاڵا + وردەکاری
 */
private function getReturnDetails($cashierId, $date)
{
    $returns = DB::table('return_items')
        ->leftJoin('products', 'return_items.Item_Code', '=', 'products.id')
        ->where('return_items.Casher_id', $cashierId)
        ->whereDate('return_items.Return_Date', $date)
        ->select(
            'products.name as product_name',
            'return_items.Amount',
            'return_items.Sale_Price',
            'return_items.Return_Total',
            'return_items.Return_Cause'
        )
        ->get();

    if ($returns->isEmpty()) {
        return '—';
    }

    return $returns->map(function ($item) {
        $productName = $item->product_name ?? 'نەناسراو';
        $amount = $item->Amount ?? 0;
        $price = number_format($item->Sale_Price ?? 0);
        $total = number_format($item->Return_Total ?? 0);
        $cause = $item->Return_Cause ? " - {$item->Return_Cause}" : '';
        
        return "{$productName} ({$amount} × {$price} = {$total} د.ع){$cause}";
    })->implode(' | ');
}
}