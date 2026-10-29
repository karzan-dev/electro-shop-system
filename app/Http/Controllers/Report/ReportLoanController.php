<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportLoanController extends Controller
{
    /**
     * Display a listing of loans.
     */
    public function index(Request $request)
    {
        // ئەم مێتۆدە بەتاڵە یان دەتوانیت ڕێدایەرێکت بکەیت بۆ debtors
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        return view('loans.create');
    }

    /**
     * Store a newly created loan in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $lastSale = DB::table('sales')->latest('id')->first();
            $nextNumber = $lastSale ? (int) str_replace('INV-', '', $lastSale->invoice_number) + 1 : 1;
            $invoiceNumber = 'INV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $customerName   = $request->input('customer_name');
            $phoneNumber    = $request->input('customer_phone');
            $address        = $request->input('customer_address');
            $advancePayment = $request->input('advance_payment') ?? 0;
            $user_id        = Auth::id();
            $subtotal       = $request->input('subtotal');
            $discount       = $request->input('discount') ?? 0;
            $items          = $request->input('items');
            $period         = $request->input('credit_period');
            $total          = $subtotal - $discount;

            $time_to_return = $request->input('time_to_return')
                ? date('Y-m-d', strtotime($request->input('time_to_return') . ' +1 day'))
                : date('Y-m-d', strtotime("+$period days +1 day"));

            $credit_amount  = $total - $advancePayment;

            $exists = DB::table('customer')
                ->where('name', $customerName)
                ->where('number_phone', $phoneNumber)
                ->exists();

            if (!$exists) {
                DB::table('customer')->insert([
                    'name' => $customerName,
                    'number_phone' => $phoneNumber,
                    'address' => $address,
                ]);
            }

            $saleId = DB::table('sales')->insertGetId([
                'invoice_number' => $invoiceNumber,
                'user_id' => $user_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if($items) {
                foreach ($items as $item) {
                    $product = DB::table('products')->where('id', $item['product_id'])->first();

                    DB::table('sale_items')->insert([
                        'sale_id' => $saleId,
                        'product_id' => $item['product_id'],
                        'product_name' => $product->name ?? null,
                        'purchase_price' => $product->purchase_price ?? 0,
                        'selling_price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'total' => $item['quantity'] * $item['price'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $customerId = DB::table('customer')->where('number_phone', $phoneNumber)->first()->id;
            
            DB::table('loans')->insert([
                'sels_id' => $saleId,
                'invoice_number' => $invoiceNumber,
                'customer_id' => $customerId,
                'currency' => $advancePayment,
                'period' => $credit_amount,
                'total' => $total,
                'status' => 2,
                'time_to_return' => $time_to_return,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'invoice_number' => $invoiceNumber,
                'message' => 'فرۆشتن بە سەرکەوتوویی ئەنجامدرا'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get debtors list with date filtering and summary
     */
    public function getDebtorsList(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $status = $request->input('status', 'all');
            $sort = $request->input('sort', 'name');
            $perPage = (int) $request->input('per_page', 15);
            $page = (int) $request->input('page', 1);
            
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $offset = ($page - 1) * $perPage;

            $baseQuery = DB::table('loans')
                ->leftJoin('customer', 'customer.id', '=', 'loans.customer_id')
                ->leftJoin('sales', 'sales.invoice_number', '=', 'loans.invoice_number')
                ->leftJoin('sale_items', 'sale_items.sale_id', '=', 'sales.id')
                ->leftJoin('products', 'products.id', '=', 'sale_items.product_id')
                ->leftJoin('private_goods', 'private_goods.id', '=', 'loans.private_goods_id')
                ->where('loans.total', '>', 0);

            $countQuery = DB::table('loans')
                ->leftJoin('customer', 'customer.id', '=', 'loans.customer_id')
                ->leftJoin('sales', 'sales.invoice_number', '=', 'loans.invoice_number')
                ->leftJoin('sale_items', 'sale_items.sale_id', '=', 'sales.id')
                ->leftJoin('products', 'products.id', '=', 'sale_items.product_id')
                ->leftJoin('private_goods', 'private_goods.id', '=', 'loans.private_goods_id')
                ->where('loans.total', '>', 0);

            $query = clone $baseQuery;
            $query->select(
                'loans.id',
                'loans.invoice_number',
                'loans.customer_id',
                'loans.currency',
                'loans.period',
                'loans.total',
                'loans.status as loan_status',
                'loans.time_to_return',
                'loans.created_at',
                'loans.updated_at',
                'customer.name as customer_name',
                'customer.number_phone as customer_phone',
                'customer.address as customer_address',
                'products.name as product_name',
                'products.company as product_company',
                'products.image_producte_path as product_image',
                'products.image_product_camera as product_camera_image',
                'sale_items.quantity as product_quantity',
                'sale_items.selling_price as product_price',
                'loans.private_goods_id',
                'private_goods.id as private_good_id',
                'private_goods.name as private_good_name',
                'private_goods.company as private_good_company'
            );

            if ($startDate && $endDate) {
                $query->whereBetween(DB::raw('DATE(loans.created_at)'), [$startDate, $endDate]);
                $countQuery->whereBetween(DB::raw('DATE(loans.created_at)'), [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->whereDate('loans.created_at', '>=', $startDate);
                $countQuery->whereDate('loans.created_at', '>=', $startDate);
            } elseif ($endDate) {
                $query->whereDate('loans.created_at', '<=', $endDate);
                $countQuery->whereDate('loans.created_at', '<=', $endDate);
            }

            if (!empty($search)) {
                $searchFilter = function ($q) use ($search) {
                    $q->where('customer.name', 'LIKE', "%{$search}%")
                        ->orWhere('customer.number_phone', 'LIKE', "%{$search}%")
                        ->orWhere('loans.invoice_number', 'LIKE', "%{$search}%")
                        ->orWhere('products.name', 'LIKE', "%{$search}%")
                        ->orWhere('products.company', 'LIKE', "%{$search}%")
                        ->orWhere('private_goods.name', 'LIKE', "%{$search}%")
                        ->orWhere('private_goods.company', 'LIKE', "%{$search}%")
                        ->orWhere('customer.address', 'LIKE', "%{$search}%");
                };

                $query->where($searchFilter);
                $countQuery->where($searchFilter);
            }

            $today = date('Y-m-d');

            if ($status === 'active') {
                $query->where('loans.time_to_return', '>', $today);
                $countQuery->where('loans.time_to_return', '>', $today);
            } elseif ($status === 'overdue') {
                $query->where('loans.time_to_return', '<', $today);
                $countQuery->where('loans.time_to_return', '<', $today);
            } elseif ($status === 'warning') {
                $nextWeek = date('Y-m-d', strtotime('+7 days'));
                $query->whereBetween('loans.time_to_return', [$today, $nextWeek]);
                $countQuery->whereBetween('loans.time_to_return', [$today, $nextWeek]);
            }

            switch ($sort) {
                case 'amount':
                    $query->orderBy('loans.total', 'desc');
                    break;
                case 'amount_asc':
                    $query->orderBy('loans.total', 'asc');
                    break;
                case 'date':
                    $query->orderBy('loans.created_at', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('loans.created_at', 'asc');
                    break;
                case 'due_date':
                    $query->orderBy('loans.time_to_return', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('customer.name', 'desc');
                    break;
                default:
                    $query->orderBy('customer.name', 'asc');
            }

            $totalLoans = $countQuery->distinct('loans.id')->count('loans.id');

            $summary = $this->getFilteredSummary($startDate, $endDate, $search, $status);

            $loans = $query
                ->distinct()
                ->skip($offset)
                ->take($perPage)
                ->get()
                ->groupBy('id');

            $debtors = [];

            foreach ($loans as $loanId => $loanGroup) {
                $loan = $loanGroup->first();
                
                $products = [];
                $productNames = [];
                $companies = [];
                $productImages = [];
                
                foreach ($loanGroup as $item) {
                    $itemProductName = $item->product_name ?? $item->private_good_name;
                    $itemCompany = $item->product_company ?? $item->private_good_company;
                    
                    if ($itemProductName) {
                        $productNames[] = $itemProductName;
                        
                        $products[] = [
                            'name' => $itemProductName,
                            'company' => $itemCompany,
                            'image' => $item->product_image ?? $item->product_camera_image,
                            'quantity' => $item->product_quantity,
                            'price' => $item->product_price,
                            'is_private_good' => !empty($item->private_good_id)
                        ];
                        
                        if ($itemCompany && !in_array($itemCompany, $companies)) {
                            $companies[] = $itemCompany;
                        }
                        
                        if (($item->product_image || $item->product_camera_image) && !in_array($item->product_image ?? $item->product_camera_image, $productImages)) {
                            $productImages[] = $item->product_image ?? $item->product_camera_image;
                        }
                    }
                }

                if (empty($products)) {
                    $allPrivateGoodsForLoan = DB::table('private_goods')
                        ->select('id', 'name', 'company')
                        ->get();
                    
                    foreach ($allPrivateGoodsForLoan as $privateGood) {
                        $productNames[] = $privateGood->name;
                        $products[] = [
                            'name' => $privateGood->name,
                            'company' => $privateGood->company,
                            'image' => null,
                            'quantity' => null,
                            'price' => null,
                            'is_private_good' => true
                        ];
                        
                        if ($privateGood->company && !in_array($privateGood->company, $companies)) {
                            $companies[] = $privateGood->company;
                        }
                    }
                }

                if ($loan->currency == $loan->total) {
                    $loanStatus = 'paidoff';
                } else {
                    if ($loan->time_to_return < $today) {
                        $loanStatus = 'overdue';
                    } elseif ($loan->time_to_return <= date('Y-m-d', strtotime('+7 days'))) {
                        $loanStatus = 'warning';
                    } else {
                        $loanStatus = 'active';
                    }
                }

                $firstProductImage = !empty($productImages) ? $productImages[0] : null;
                
                $productImageUrl = null;
                if ($firstProductImage) {
                    if (filter_var($firstProductImage, FILTER_VALIDATE_URL)) {
                        $productImageUrl = $firstProductImage;
                    } else {
                        $productImageUrl = asset($firstProductImage);
                    }
                }

                $productNameDisplay = !empty($productNames) 
                    ? implode(', ', array_unique($productNames)) 
                    : '—';

                $companyDisplay = !empty($companies) 
                    ? implode(', ', array_unique($companies)) 
                    : '—';

                // 🔴 دیاریکردنی ناوی پسوڵە - ئەگەر 0 یان بەتاڵ بوو، "قەرزی سەر دەفتەر" پیشان بدە
                $invoiceDisplay = ($loan->invoice_number && $loan->invoice_number != '0' && $loan->invoice_number != '') 
                    ? $loan->invoice_number 
                    : 'قەرزی سەر دەفتەر';

                $debtors[] = [
                    'id' => $loan->id,
                    'customer_name' => $loan->customer_name ?? '',
                    'customer_phone' => $loan->customer_phone ?? '',
                    'customer_address' => $loan->customer_address ?? '',
                    'product_name' => $productNameDisplay,
                    'company' => $companyDisplay,
                    'product_image' => $productImageUrl,
                    'products' => $products,
                    'remaining_amount' => (float)$loan->total,
                    'total_amount' => (float)$loan->total,
                    'paid_amount' => (float)($loan->paid_amount ?? 0),
                    'due_date' => $loan->time_to_return,
                    'status' => $loanStatus,
                    'created_at' => $loan->created_at
                        ? date('Y-m-d', strtotime($loan->created_at))
                        : null,
                    'invoice_number' => $invoiceDisplay,
                    'currency' => $loan->currency ?? 'IQD',
                    'period' => $loan->period
                ];
            }

            return response()->json([
                'success' => true,
                'debtors' => [
                    'data' => $debtors,
                    'current_page' => $page,
                    'last_page' => ceil($totalLoans / $perPage),
                    'per_page' => $perPage,
                    'total' => $totalLoans,
                    'from' => $totalLoans > 0 ? $offset + 1 : 0,
                    'to' => min($offset + $perPage, $totalLoans)
                ],
                'summary' => $summary
            ]);

        } catch (\Exception $e) {
            Log::error('DebtorController Error: ' . $e->getMessage());
            Log::error('DebtorController Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching debtors: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get filtered summary statistics
     */
    private function getFilteredSummary($startDate = null, $endDate = null, $search = '', $status = 'all')
    {
        $today = date('Y-m-d');
        $nextWeek = date('Y-m-d', strtotime('+7 days'));
        
        $summaryQuery = DB::table('loans')
            ->leftJoin('customer', 'customer.id', '=', 'loans.customer_id')
            ->leftJoin('sales', 'sales.invoice_number', '=', 'loans.invoice_number')
            ->leftJoin('sale_items', 'sale_items.sale_id', '=', 'sales.id')
            ->leftJoin('products', 'products.id', '=', 'sale_items.product_id')
            ->leftJoin('private_goods', 'private_goods.id', '=', 'loans.private_goods_id')
            ->where('loans.total', '>', 0);

        if ($startDate && $endDate) {
            $summaryQuery->whereBetween(DB::raw('DATE(loans.created_at)'), [$startDate, $endDate]);
        } elseif ($startDate) {
            $summaryQuery->whereDate('loans.created_at', '>=', $startDate);
        } elseif ($endDate) {
            $summaryQuery->whereDate('loans.created_at', '<=', $endDate);
        }

        if (!empty($search)) {
            $summaryQuery->where(function($q) use ($search) {
                $q->where('customer.name', 'LIKE', "%{$search}%")
                    ->orWhere('customer.number_phone', 'LIKE', "%{$search}%")
                    ->orWhere('loans.invoice_number', 'LIKE', "%{$search}%")
                    ->orWhere('products.name', 'LIKE', "%{$search}%")
                    ->orWhere('products.company', 'LIKE', "%{$search}%")
                    ->orWhere('private_goods.name', 'LIKE', "%{$search}%")
                    ->orWhere('private_goods.company', 'LIKE', "%{$search}%")
                    ->orWhere('customer.address', 'LIKE', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $summaryQuery->where('loans.time_to_return', '>', $today);
        } elseif ($status === 'overdue') {
            $summaryQuery->where('loans.time_to_return', '<', $today);
        } elseif ($status === 'warning') {
            $summaryQuery->whereBetween('loans.time_to_return', [$today, $nextWeek]);
        }

        $distinctLoans = (clone $summaryQuery)->distinct('loans.id')->get(['loans.id', 'loans.total', 'loans.currency', 'loans.period']);
        
        $totalDebtors = $distinctLoans->count();
        $totalAmount = $distinctLoans->sum('total');
        $totalPaid = $distinctLoans->sum('currency');
        $totalRemaining = $distinctLoans->sum('period');

        return [
            'total_debtors' => $totalDebtors,
            'total_amount' => (float)$totalAmount,
            'total_paid' => (float)$totalPaid,
            'total_remaining' => (float)$totalRemaining,
        ];
    }

    /**
     * Display the specified debtor with all sale items.
     */
    public function showDebtor($id)
    {
        try {
            $loan = DB::table('loans')
                ->leftJoin('customer', 'customer.id', '=', 'loans.customer_id')
                ->where('loans.id', $id)
                ->select(
                    'loans.*',
                    'customer.name as customer_name',
                    'customer.number_phone as customer_phone',
                    'customer.address as customer_address'
                )
                ->first();

            if (!$loan) {
                return response()->json([
                    'success' => false,
                    'message' => 'قەرز نەدۆزرایەوە'
                ], 404);
            }

            $saleItem = DB::table('sale_items')->where('id', $loan->sels_id)->first();
            
            $items = collect([]);
            if ($saleItem) {
                $items = DB::table('sale_items')
                    ->where('sale_id', $saleItem->sale_id)
                    ->select(
                        'id',
                        'sale_id',
                        'product_id',
                        'product_name',
                        'purchase_price',
                        'selling_price',
                        'quantity',
                        'total',
                        'created_at'
                    )
                    ->get();
            }

            $sale = null;
            if ($saleItem) {
                $sale = DB::table('sales')->where('id', $saleItem->sale_id)->first();
            }

            $today = date('Y-m-d');
            
            if ($loan->time_to_return < $today) {
                $loanStatus = 'overdue';
            } elseif ($loan->time_to_return <= date('Y-m-d', strtotime('+7 days'))) {
                $loanStatus = 'warning';
            } else {
                $loanStatus = 'active';
            }

            $advancePayment = (float)($loan->currency ?? 0);
            $creditAmount = (float)($loan->period ?? 0);
            $totalAmount = (float)($loan->total ?? 0);
            $remainingAmount = $totalAmount - $advancePayment;
            $paymentPercentage = $totalAmount > 0 ? ($advancePayment / $totalAmount) * 100 : 0;

            // 🔴 دیاریکردنی ناوی پسوڵە بۆ وردەکاری
            $invoiceDisplay = ($loan->invoice_number && $loan->invoice_number != '0' && $loan->invoice_number != '') 
                ? $loan->invoice_number 
                : 'قەرزی سەر دەفتەر';

            $debtor = [
                'id' => $loan->id,
                'sale_id' => $sale->id ?? null,
                'sels_id' => $loan->sels_id,
                'customer_id' => $loan->customer_id,
                'customer_name' => $loan->customer_name ?? '',
                'customer_phone' => $loan->customer_phone ?? '',
                'customer_address' => $loan->customer_address ?? '',
                'invoice_number' => $invoiceDisplay,
                'subtotal' => (float)($sale->subtotal ?? 0),
                'discount' => (float)($sale->discount ?? 0),
                'total_amount' => $totalAmount,
                'paid_amount' => $advancePayment,
                'remaining_amount' => max(0, $remainingAmount),
                'advance_payment' => $advancePayment,
                'credit_amount' => $creditAmount,
                'credit_period' => $loan->period,
                'due_date' => $loan->time_to_return,
                'due_date_formatted' => $loan->time_to_return ? date('Y-m-d', strtotime($loan->time_to_return)) : null,
                'status' => $loanStatus,
                'status_code' => $loan->status ?? 2,
                'payment_percentage' => round($paymentPercentage, 2),
                'is_overdue' => $loan->time_to_return < $today,
                'days_overdue' => $loan->time_to_return < $today ? 
                    floor((strtotime($today) - strtotime($loan->time_to_return)) / (60 * 60 * 24)) : 0,
                'days_remaining' => $loan->time_to_return >= $today ? 
                    floor((strtotime($loan->time_to_return) - strtotime($today)) / (60 * 60 * 24)) : 0,
                'created_at' => $loan->created_at ? date('Y-m-d H:i:s', strtotime($loan->created_at)) : null,
                'updated_at' => $loan->updated_at ? date('Y-m-d H:i:s', strtotime($loan->updated_at)) : null,
                'user_id' => $sale->user_id ?? null,
                'items' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'sale_id' => $item->sale_id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'purchase_price' => (float)$item->purchase_price,
                        'selling_price' => (float)$item->selling_price,
                        'quantity' => (int)$item->quantity,
                        'total' => (float)$item->total,
                        'profit_per_item' => (float)($item->selling_price - $item->purchase_price),
                        'total_profit' => (float)(($item->selling_price - $item->purchase_price) * $item->quantity),
                        'created_at' => $item->created_at
                    ];
                }),
            ];

            return response()->json([
                'success' => true,
                'debtor' => $debtor
            ]);

        } catch (\Exception $e) {
            Log::error('Show Debtor Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Make a payment for a loan
     */
    public function makePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'debtor_id' => 'required|integer|exists:loans,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:now,later',
            'later_date' => 'nullable|date',
            'later_note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $loan = DB::table('loans')->where('id', $request->debtor_id)->first();

            if (!$loan) {
                return response()->json([
                    'success' => false,
                    'message' => 'قەرز نەدۆزرایەوە'
                ], 404);
            }

            $amount = (float) $request->amount;
            $paymentType = $request->payment_type;

            if ($paymentType === 'now' && $amount > 0) {
                $newCurrency = (float)($loan->currency ?? 0) + $amount;
                $newPeriod = max(0, (float)($loan->total ?? 0) - $newCurrency);
                
                DB::table('loans')
                    ->where('id', $request->debtor_id)
                    ->update([
                        'currency' => $newCurrency,
                        'period' => $newPeriod,
                        'status' => $newPeriod <= 0 ? 1 : 2,
                        'updated_at' => now(),
                    ]);
            }

            DB::table('loan_payments')->insert([
                'loan_id' => $request->debtor_id,
                'amount' => $amount,
                'payment_type' => $paymentType,
                'later_date' => $request->later_date,
                'note' => $request->later_note,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $paymentType === 'now' 
                    ? 'پارەدان بە سەرکەوتوویی تۆمارکرا' 
                    : 'پارەدانی دواخراو بە سەرکەوتوویی تۆمارکرا'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment history for a specific debtor
     */
    public function getPaymentHistory(Request $request)
    {
        try {
            $debtorId = $request->input('debtor_id');

            if (!$debtorId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ناسنامەی قەرزار پێویستە'
                ], 400);
            }

            $payments = DB::table('loan_payments')
                ->where('loan_id', $debtorId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'payments' => $payments
            ]);

        } catch (\Exception $e) {
            Log::error('Payment History Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا'
            ], 500);
        }
    }

    /**
     * Delete a debtor/loan
     */
    public function destroyDebtor($id)
    {
        try {
            DB::beginTransaction();

            $loan = DB::table('loans')->where('id', $id)->first();

            if (!$loan) {
                return response()->json([
                    'success' => false,
                    'message' => 'قەرز نەدۆزرایەوە'
                ], 404);
            }

            DB::table('loan_payments')->where('loan_id', $id)->delete();

            $saleItem = DB::table('sale_items')->where('id', $loan->sels_id)->first();
            if ($saleItem) {
                DB::table('sale_items')->where('sale_id', $saleItem->sale_id)->delete();
                DB::table('sales')->where('id', $saleItem->sale_id)->delete();
            }

            DB::table('loans')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'قەرز بە سەرکەوتوویی سڕایەوە'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete Debtor Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for dashboard using DB facade
     */
    private function getStatistics()
    {
        $today = date('Y-m-d');
        $nextWeek = date('Y-m-d', strtotime('+7 days'));
        
        $totalDebtors = DB::table('loans')->where('total', '>', 0)->count();
        $totalDebt = DB::table('loans')->where('total', '>', 0)->sum('total');
        
        $activeDebtors = DB::table('loans')
            ->where('total', '>', 0)
            ->where('time_to_return', '>', $today)
            ->count();
        
        $overdueDebtors = DB::table('loans')
            ->where('total', '>', 0)
            ->where('time_to_return', '<', $today)
            ->count();
        
        $warningDebtors = DB::table('loans')
            ->where('total', '>', 0)
            ->where('time_to_return', '>=', $today)
            ->where('time_to_return', '<=', $nextWeek)
            ->count();
        
        $averageDebt = $totalDebtors > 0 ? $totalDebt / $totalDebtors : 0;
        $highestDebt = DB::table('loans')->where('total', '>', 0)->max('total') ?? 0;

        return [
            'total_debtors' => $totalDebtors,
            'total_debt' => (float) $totalDebt,
            'active_debtors' => $activeDebtors,
            'overdue_debtors' => $overdueDebtors,
            'warning_debtors' => $warningDebtors,
            'average_debt' => (float) $averageDebt,
            'highest_debt' => (float) $highestDebt,
        ];
    }
}