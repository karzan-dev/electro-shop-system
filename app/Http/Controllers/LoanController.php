<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class LoanController extends Controller
{
    /**
     * Display a listing of loans.
     */
    public function index(Request $request)
    {
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
        // 🔹 Generate invoice number
        $lastSale = DB::table('sales')->latest('id')->first();
        $nextNumber = $lastSale ? (int) str_replace('INV-', '', $lastSale->invoice_number) + 1 : 1;
        $invoiceNumber = 'INV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // 🔹 Input variables
        $customerName   = $request->input('customer_name');
        $phoneNumber    = $request->input('customer_phone');
        $address        = $request->input('customer_address');
        $advancePayment = $request->input('advance_payment') ?? 0;
        $user_id        = Auth::id();
        $total1          = $request->input('total');
        $subtotal       = $request->input('subtotal');
        $discount       = $request->input('discount') ?? 0;
        $items          = $request->input('items'); // array
        $period         = $request->input('credit_period'); // days
        $total=$subtotal - $discount;

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

        // 🔹 1. Insert into sales
        $saleId = DB::table('sales')->insertGetId([
            'invoice_number' => $invoiceNumber,
            'user_id' => $user_id,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 🔹 2. Insert sale items
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

        // 🔹 3. Insert into loans (تەنها یەک جار بۆ هەر فرۆشتنێک)
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

        // 🔹 Return JSON response
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


public function getDebtorsList(Request $request)
{
    try {

        $search = $request->input('search', '');
        $status = $request->input('status', 'all');
        $sort = $request->input('sort', 'name');
        $perPage = (int) $request->input('per_page', 15);
        $page = (int) $request->input('page', 1);

        $offset = ($page - 1) * $perPage;

        // Base query with all needed joins
        $baseQuery = DB::table('loans')
            ->leftJoin('customer', 'customer.id', '=', 'loans.customer_id')
            ->leftJoin('sales', 'sales.invoice_number', '=', 'loans.invoice_number')
            ->leftJoin('sale_items', 'sale_items.sale_id', '=', 'sales.id')
            ->leftJoin('products', 'products.id', '=', 'sale_items.product_id')
            ->leftJoin('private_goods', 'private_goods.id', '=', 'loans.private_goods_id')  // زیادکردنی join بۆ private_goods
            ->where('loans.total', '>', 0);

        // Count query (without select and order for efficiency)
        $countQuery = DB::table('loans')
            ->leftJoin('customer', 'customer.id', '=', 'loans.customer_id')
            ->leftJoin('sales', 'sales.invoice_number', '=', 'loans.invoice_number')
            ->leftJoin('sale_items', 'sale_items.sale_id', '=', 'sales.id')
            ->leftJoin('products', 'products.id', '=', 'sale_items.product_id')
            ->leftJoin('private_goods', 'private_goods.id', '=', 'loans.private_goods_id')  // زیادکردنی join بۆ private_goods
            ->where('loans.total', '>', 0);

        // Main query with all needed fields
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
            // زیادکردنی paid_amount
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
            'loans.private_goods_id',  // زیادکردنی private_good_id
            'private_goods.id as private_good_id',
            'private_goods.name as private_good_name',  // زیادکردنی ناوی private_goods
            'private_goods.company as private_good_company'  // زیادکردنی کۆمپانیای private_goods
        );

        // SEARCH
        if (!empty($search)) {
            $searchFilter = function ($q) use ($search) {
                $q->where('customer.name', 'LIKE', "%{$search}%")
                    ->orWhere('customer.number_phone', 'LIKE', "%{$search}%")
                    ->orWhere('loans.invoice_number', 'LIKE', "%{$search}%")
                    ->orWhere('products.name', 'LIKE', "%{$search}%")
                    ->orWhere('products.company', 'LIKE', "%{$search}%")
                    ->orWhere('private_goods.name', 'LIKE', "%{$search}%")  // زیادکردنی گەڕان بۆ private_goods
                    ->orWhere('private_goods.company', 'LIKE', "%{$search}%")  // زیادکردنی گەڕان بۆ private_goods
                    ->orWhere('customer.address', 'LIKE', "%{$search}%");
            };

            $query->where($searchFilter);
            $countQuery->where($searchFilter);
        }

        $today = date('Y-m-d');

        // STATUS FILTER
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

        // SORT
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

        // Get total count
        $totalLoans = $countQuery->distinct('loans.id')->count('loans.id');

        // Get paginated results
        $loans = $query
            ->distinct()
            ->skip($offset)
            ->take($perPage)
            ->get()
            ->groupBy('id');

        $stats = $this->getStatistics();

        $debtors = [];

        foreach ($loans as $loanId => $loanGroup) {
            $loan = $loanGroup->first();
            
            // Collect all products for this loan
            $products = [];
            $productNames = [];
            $companies = [];
            $productImages = [];
            
            foreach ($loanGroup as $item) {
                // دیاریکردنی ناوی کاڵا (لە products یان private_goods)
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
                        'is_private_good' => !empty($item->private_good_id)  // ئاماژە بۆ ئەوەی کە ئایا private_good یە
                    ];
                    
                    if ($itemCompany && !in_array($itemCompany, $companies)) {
                        $companies[] = $itemCompany;
                    }
                    
                    if (($item->product_image || $item->product_camera_image) && !in_array($item->product_image ?? $item->product_camera_image, $productImages)) {
                        $productImages[] = $item->product_image ?? $item->product_camera_image;
                    }
                }
            }

            // ئەگەر هیچ کاڵایەک نەدۆزرایەوە، هەموو private_goods کان پیشان بدە
            if (empty($products)) {
                // هێنانی هەموو private_goods بۆ ئەم loan
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

            if( $loan->currency==$loan->total) {
                $loanStatus = 'paidoff';
            }else{
        
            if ($loan->time_to_return < $today) {
                $loanStatus = 'overdue';
            } elseif ($loan->time_to_return <= date('Y-m-d', strtotime('+7 days'))) {
                $loanStatus = 'warning';
            }
             else {
                $loanStatus = 'active';
            }
        }

            // Get the first product image
            $firstProductImage = !empty($productImages) ? $productImages[0] : null;
            
            // Build image URL
            $productImageUrl = null;
            if ($firstProductImage) {
                if (filter_var($firstProductImage, FILTER_VALIDATE_URL)) {
                    $productImageUrl = $firstProductImage;
                } else {
                    $productImageUrl = asset($firstProductImage);
                }
            }

            // ناوی کاڵاکان بە "," جیا بکەرەوە
            $productNameDisplay = !empty($productNames) 
                ? implode(', ', array_unique($productNames)) 
                : '—';

            // کۆمپانیاکان بە "," جیا بکەرەوەb
            $companyDisplay = !empty($companies) 
                ? implode(', ', array_unique($companies)) 
                : '—';

            $debtors[] = [
                'id' => $loan->id,
                'customer_name' => $loan->customer_name ?? '',
                'customer_phone' => $loan->customer_phone ?? '',
                'customer_address' => $loan->customer_address ?? '',
                'product_name' => $productNameDisplay,
                'company' => $companyDisplay,
                'product_image' => $productImageUrl,
                'products' => $products,  // هەموو کاڵاکان (products + private_goods)
                'remaining_amount' => (float)$loan->total,
                'total_amount' => (float)$loan->total,
                'paid_amount' => (float)($loan->paid_amount ?? 0),
                'due_date' => $loan->time_to_return,
                'status' => $loanStatus,
                'created_at' => $loan->created_at
                    ? date('Y-m-d', strtotime($loan->created_at))
                    : null,
                'invoice_number' => $loan->invoice_number,
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
            'stats' => $stats
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
 * Display the specified debtor.
 */
/**
 * Display the specified debtor with all sale items.
 */
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

        // Get the sale item linked to this loan via sels_id
        $saleItem = DB::table('sale_items')->where('id', $loan->sels_id)->first();
        
        // Get ALL items from the same sale
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

        // Get sale information
        $sale = null;
        if ($saleItem) {
            $sale = DB::table('sales')->where('id', $saleItem->sale_id)->first();
        }

        $today = date('Y-m-d');
        
        // Determine status based on dates
        if ($loan->time_to_return < $today) {
            $loanStatus = 'overdue';
        } elseif ($loan->time_to_return <= date('Y-m-d', strtotime('+7 days'))) {
            $loanStatus = 'warning';
        } else {
            $loanStatus = 'active';
        }

        // Calculate payment details
        // In your structure: currency field = advance_payment, period field = credit_amount
        $advancePayment = (float)($loan->currency ?? 0);
        $creditAmount = (float)($loan->period ?? 0);
        $totalAmount = (float)($loan->total ?? 0);
        $remainingAmount = $totalAmount - $advancePayment;
        $paymentPercentage = $totalAmount > 0 ? ($advancePayment / $totalAmount) * 100 : 0;

        $debtor = [
            'id' => $loan->id,
            'sale_id' => $sale->id ?? null,
            'sels_id' => $loan->sels_id,
            'customer_id' => $loan->customer_id,
            'customer_name' => $loan->customer_name ?? '',
            'customer_phone' => $loan->customer_phone ?? '',
            'customer_address' => $loan->customer_address ?? '',
            'invoice_number' => $loan->invoice_number,
            'subtotal' => (float)($sale->subtotal ?? 0),
            'discount' => (float)($sale->discount ?? 0),
            'total_amount' => $totalAmount,
            'paid_amount' => $advancePayment,
            'remaining_amount' => max(0, $remainingAmount),
            'advance_payment' => $advancePayment,
            'credit_amount' => $creditAmount,
            'credit_period' => $loan->period, // days
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

    /**
     * Display the specified loan.
     */
    public function show($id)
    {
        $loan = DB::table('loans')->where('id', $id)->first();

        if (!$loan) {
            return redirect()->route('loans.index')
                ->with('error', 'قەرز نەدۆزرایەوە');
        }

        $items = DB::table('sale_items')
            ->where('loan_id', $id)
            ->get();

        return view('loans.show', compact('loan', 'items'));
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function edit($id)
    {
        $loan = DB::table('loans')->where('id', $id)->first();

        if (!$loan) {
            return redirect()->route('loans.index')
                ->with('error', 'قەرز نەدۆزرایەوە');
        }

        $items = DB::table('sale_items')
            ->where('loan_id', $id)
            ->get();

        return view('loans.edit', compact('loan', 'items'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'currency' => 'required|in:IQD,USD',
            'period' => 'required|integer|min:1|max:365',
            'total' => 'required|numeric|min:0',
            'advance_payment' => 'nullable|numeric|min:0',
            'time_to_return' => 'required|date',
            'status' => 'required|in:pending,partial,paid,overdue',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $advancePayment = $request->advance_payment ?? 0;
            $creditAmount = $request->total - $advancePayment;

            // Update loan
            DB::table('loans')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'currency' => $request->currency,
                    'period' => $request->period,
                    'total' => $request->total,
                    'advance_payment' => $advancePayment,
                    'credit_amount' => $creditAmount,
                    'time_to_return' => $request->time_to_return,
                    'status' => $request->status,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()->route('loans.show', $id)
                ->with('success', 'قەرز بە سەرکەوتوویی نوێکرایەوە');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'هەڵەیەک ڕوویدا: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Delete sale items first
            DB::table('sale_items')->where('loan_id', $id)->delete();

            // Delete loan
            DB::table('loans')->where('id', $id)->delete();

            DB::commit();

            return redirect()->route('loans.index')
                ->with('success', 'قەرز بە سەرکەوتوویی سڕدرایەوە');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'هەڵەیەک ڕوویدا: ' . $e->getMessage());
        }
    }

    /**
     * Make a payment for a loan.
     */
    public function makePayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $loan = DB::table('loans')->where('id', $id)->first();

            if (!$loan) {
                return redirect()->back()
                    ->with('error', 'قەرز نەدۆزرایەوە');
            }

            $newPaidAmount = $loan->advance_payment + $request->payment_amount;
            $remainingCredit = $loan->credit_amount - $request->payment_amount;

            // Determine status
            $status = 'pending';
            if ($remainingCredit <= 0) {
                $status = 'paid';
            } elseif ($newPaidAmount > 0) {
                $status = 'partial';
            }

            // Update loan
            DB::table('loans')
                ->where('id', $id)
                ->update([
                    'advance_payment' => $newPaidAmount,
                    'credit_amount' => max(0, $remainingCredit),
                    'status' => $status,
                    'updated_at' => now(),
                ]);

            // Record payment
            DB::table('loan_payments')->insert([
                'loan_id' => $id,
                'amount' => $request->payment_amount,
                'payment_date' => $request->payment_date,
                'notes' => $request->notes,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('loans.show', $id)
                ->with('success', 'پارەدان بە سەرکەوتوویی تۆمارکرا');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'هەڵەیەک ڕوویدا: ' . $e->getMessage());
        }
    }

    /**
     * Get overdue loans.
     */
    public function overdue()
    {
        $today = date('Y-m-d');

        $loans = DB::table('loans')
            ->where('time_to_return', '<', $today)
            ->where('status', '!=', 'paid')
            ->where('credit_amount', '>', 0)
            ->orderBy('time_to_return', 'asc')
            ->paginate(20);

        $totalOverdue = DB::table('loans')
            ->where('time_to_return', '<', $today)
            ->where('status', '!=', 'paid')
            ->where('credit_amount', '>', 0)
            ->sum('credit_amount');

        return view('loans.overdue', compact('loans', 'totalOverdue'));
    }

    /**
     * Get loan statistics.
     */
    public function statistics()
    {
        $totalLoans = DB::table('loans')->count();
        $totalAmount = DB::table('loans')->sum('total');
        $totalCredit = DB::table('loans')->sum('credit_amount');
        $totalPaid = DB::table('loans')->sum('advance_payment');

        $pendingLoans = DB::table('loans')->where('status', 'pending')->count();
        $partialLoans = DB::table('loans')->where('status', 'partial')->count();
        $paidLoans = DB::table('loans')->where('status', 'paid')->count();
        $overdueLoans = DB::table('loans')
            ->where('time_to_return', '<', date('Y-m-d'))
            ->where('status', '!=', 'paid')
            ->count();

        $today = date('Y-m-d');
        $weekly = DB::table('loans')
            ->where('time_to_return', '>=', $today)
            ->where('time_to_return', '<=', date('Y-m-d', strtotime('+7 days')))
            ->where('status', '!=', 'paid')
            ->count();

        $monthly = DB::table('loans')
            ->where('time_to_return', '>=', $today)
            ->where('time_to_return', '<=', date('Y-m-d', strtotime('+30 days')))
            ->where('status', '!=', 'paid')
            ->count();

        return view('loans.statistics', compact(
            'totalLoans', 'totalAmount', 'totalCredit', 'totalPaid',
            'pendingLoans', 'partialLoans', 'paidLoans', 'overdueLoans',
            'weekly', 'monthly'
        ));
    }

    /**
     * Export loans to Excel/CSV.
     */
    public function export(Request $request)
    {
        $query = DB::table('loans')
            ->select('id', 'name', 'phone_number', 'total', 'advance_payment',
                     'credit_amount', 'currency', 'time_to_return', 'status', 'created_at');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date') && $request->from_date != '') {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $loans = $query->get();

        // Generate CSV
        $filename = "loans_export_" . date('Y-m-d_H-i-s') . ".csv";
        $handle = fopen('php://temp', 'w+');

        // Add headers
        fputcsv($handle, [
            'ID', 'ناوی کڕیار', 'ژمارەی مۆبایل', 'کۆی گشتی', 'پارەی پێشەکی',
            'بڕی قەرز', 'دۆلار/دینار', 'کاتی گەڕانەوە', 'ڕەوش', 'بەرواری تۆمارکردن'
        ]);

        // Add data
        foreach ($loans as $loan) {
            fputcsv($handle, [
                $loan->id,
                $loan->name,
                $loan->phone_number,
                $loan->total,
                $loan->advance_payment,
                $loan->credit_amount,
                $loan->currency == 'IQD' ? 'دینار' : 'دۆلار',
                $loan->time_to_return,
                $this->getStatusText($loan->status),
                $loan->created_at
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Get status text in Kurdish.
     */
    private function getStatusText($status)
    {
        $statuses = [
            'pending' => 'چاوەڕوان',
            'partial' => 'بەشێک پارەدراوە',
            'paid' => 'تەواو پارەدراوە',
            'overdue' => 'دەرچووە'
        ];

        return $statuses[$status] ?? $status;
    }
}
