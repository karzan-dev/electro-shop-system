<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProductWearhouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReturnItemController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CasherController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Report\ReportwarehouseController;
use Illuminate\Http\Request;

use Fidry\CpuCoreCounter\Finder\_NProcessorFinder;
use App\Http\Controllers\Report\CreateDailyAccountingController;
use App\Http\Controllers\DebtorController;
use App\Http\Controllers\Report\StockProductController;
use App\Http\Controllers\Report\ReturnReportController;

use App\Http\Controllers\Report\ReportLoanController;
use App\Http\Controllers\withdrawalsController;

use App\Http\Controllers\CompanyDebtController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\SellerController;

use App\Http\Controllers\BrandController;

Route::get('/', function () {
    return redirect()->route('login');
});




Route::middleware('auth')->group(function () {


    Route::get('/dashboard', function () {
        return view("dashboard");
    })->name('dashboard');



    Route::get("/register-item", function () {
        return view("items.items-register");
    })->name('register-item');

    Route::post("/products-store", [ProductController::class, 'store'])->name('products.store');
    Route::post('/check-barcode', [ProductController::class, 'getProductByBarcode'])->name('barcode.check');


    Route::get("/wearhouse-register", function () {
        return view("items.wear-house");
    })->name('warehousing');

    Route::post('/products/search-by-barcode', [ProductController::class, 'searchByBarcode'])->name('products.searchByBarcode');
    Route::post('/barcode/search-by-barcode', [ProductController::class, 'ByBarcode'])->name('barcode.searchByBarcode');
    Route::post('/products/search-by-barcodess', [ProductController::class, 'searchByBarcodess']);
    Route::post('/warehousing-store', [ProductWearhouseController::class, 'store'])->name('warehousing_store');
    Route::post('/products/search-by-name', [ProductController::class, 'searchByName'])->name('products.searchByName');

    Route::post('/products/search-by-nameee', [ProductController::class, 'searchByNameee']);
    Route::get("/items-edit", function () {
        return view("items.items-edit");
    })->name('items-edit');


    Route::get('/products/autocomplete', [ProductController::class, 'autocomplete'])
        ->name('products.autocomplete');

    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    Route::post('/update', [ProductController::class, "update"])->name('products.update');

    Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    // Company routes
    Route::get('/companies/list', [ProductController::class, 'getCompaniesList'])->name('companies.list');
    Route::post('/companies/store', [ProductController::class, 'store'])->name('companies.store');


    /*
    |--------------------------------------------------------------------------
    | Casher Coin Routes
    |--------------------------------------------------------------------------
    */

    // وەرگرتنی لیستی کاشێرەکان بۆ dropdown
    Route::get('/get-data/Casher', [CasherController::class, 'getData'])->name('casher.getData');

    // وەرگرتنی زانیاری کاشێر بە ID بۆ info panel
    Route::get('/get-casher-details/{id}', [CasherController::class, 'getCasherDetails'])->name('casher.details');

    // تۆمارکردنی وردە
    Route::post('/casher-coin/store', [CasherController::class, 'store'])->name('casher.store');

// ✅ ئەمەی نوێ — دەچێت بۆ list (کە فلتەری هەیە)
Route::get('/listt', [ProductController::class, 'list'])->name('products.listt');
    /*
    |--------------------------------------------------------------------------
    | Daily Accounting Casher Routes (URIs renamed to avoid conflicts)
    |--------------------------------------------------------------------------
    */

    Route::get('/daily-accounting/casher/getData', [CreateDailyAccountingController::class, 'getData'])
        ->name('casher.getDataDetails');

    Route::get('/daily-accounting/casher/details/{id}', [CreateDailyAccountingController::class, 'getDetails'])
        ->name('daily.casher.details');


    // Invoice Routes
    Route::get('/get-invoices/Details', [CreateDailyAccountingController::class, 'getInvoices'])->name('invoicesDetails.get');
    Route::get('/invoice/Details/{id}', [CreateDailyAccountingController::class, 'show'])->name('invoiceDetails.show');

    Route::middleware(['auth', 'role:admin'])->group(function () {

        Route::get("/items-loans", function () {
            return view("items.items-loans");
        })->name('items-loans.index');

    });




    Route::get('/debtors/list', [LoanController::class, 'getDebtorsList'])->name('debtors.list');
    Route::get('/debtors/{id}/show', [LoanController::class, 'showDebtor'])->name('debtors.show');

    Route::get('/debtors/invoice/{loanId}', [LoanController::class, 'viewInvoice'])->name('debtors.invoice');
    Route::post('/debtors/return-item/{loanId}', [LoanController::class, 'returnItem'])->name('debtors.return-item');

    Route::middleware(['auth', 'role:admin,casher'])->group(function () {

        Route::get('/debtors/save-products', function (Request $request) {
            return view("items.debtor-save-products");
        })->name('debtors.save-products');

    });

    Route::get('/payment-history', [DebtorController::class, 'paymentHistory'])->name('debtors.payment-history');

    Route::post('/debtors/paywwwww', [DebtorController::class, 'pay'])->name('debtors.pay');

    // Delete route
    Route::delete('/debtors/{id}/delete', [DebtorController::class, 'destroy'])->name('debtors.delete');

    Route::post('/debtors/save', [DebtorController::class, 'debtors_save'])->name('debtors.save');

    // Route بۆ گەڕانی کڕیار
    Route::post('/customers/search', function (Request $request) {

        $searchTerm = $request->input('search_term');

        $customers = DB::table('customer')
            ->select('id', 'name', 'number_phone', 'address')
            ->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('number_phone', 'LIKE', "%{$searchTerm}%");
            })
            ->distinct()
            ->limit(8)
            ->get();

        return response()->json([
            'success' => true,
            'customers' => $customers
        ]);
    });


    // app/Http/Controllers/ProductController.php

    Route::post('/products/search-debtors', function (Request $request) {
        $term = $request->search_term;

        $products = DB::table('private_goods')
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('company', 'like', "%{$term}%");
            })
            ->select('id', 'name', 'company')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    });


    Route::post('/returns/store', [ReturnItemController::class, 'store']);


    Route::get("/Sales-Item", function () {
        return view("items.items-salles");
    })->name('sales.index');

    Route::get('/list', [ProductController::class, 'getProductsList'])->name('products.list');

    Route::post('/products/autocomplete', [ProductController::class, 'autocomplete'])->name('products.autocomplete');

    Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    Route::get('/products/search', [ProductController::class, 'searchProducts'])->name('products.search');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // لە web.php
    Route::post('/products/search-by-barcode', [ProductController::class, 'searchByBarcode'])
        ->name('products.searchByBarcode');

    // لە web.php
    Route::post('/products/home', [ProductController::class, 'search'])->name('dollar.update');
    Route::post('/products/search', [ProductController::class, 'search'])->name('sales.get-item-info');

    Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');

    Route::get('/sales/next-voucher-number', [SaleController::class, 'getNextVoucherNumber'])->name('sales.get-next-voucher');

    Route::post('/return-item-store', [ReturnItemController::class, 'store'])->name('sales.print');
    Route::post('/returns/process-return', [ReturnItemController::class, 'processReturn'])->name('returns.process-return');


    Route::get("/Stock-Item", function () {
        return view("items.items-stock");
    })->name('stock.index');

Route::get('/companies/search', [ProductController::class, 'searchCompanies'])->name('companies.search');
    Route::post('/products/search-by-barcode-sells', [ReturnItemController::class, 'searchByBarcode'])->name('products.searchByBarcode-sells');

    Route::post('/products/search-by-name-sells', [ReturnItemController::class, 'searchByName'])->name('products.searchByName-sells');

    Route::post('/returns/search-by-invoice', [ReturnItemController::class, 'searchByInvoice'])->name('returns.search.invoice');

    Route::get("/sales-credit", function () {
        return view("items.items-sales-credit");
    })->name('sales-credit.index');


    Route::middleware(['auth', 'role:admin'])->group(function () {

        Route::get('/Casher-coin', function () {
            return view('items.casher-coin');
        })->name('Casher-coin');

    });
    
    
    // Update a coin record
Route::put('/casher/coin/{id}', [CasherController::class, 'update'])
    ->name('casher.update');

// Delete a coin record
Route::delete('/casher/coin/{id}', [CasherController::class, 'destroy'])
    ->name('casher.destroy');
    
  
Route::get('/casher/all-history', [CasherController::class, 'allHistory'])->name('casher.allHistory');


    Route::post('/credit-sales/store', [LoanController::class, 'store']);


    Route::get("/create-barcode", function () {
        return view("items.create-barcode");
    })->name('create-barcode');


    Route::get("/reports-warehouse", function () {
        return view("items.report.reports-warehouse");
    })->name('reports-warehouse');
    
    
        Route::get("/seller", function () {
        return view("items.seller");
    })->name('seller');
   

    Route::get('/warehouse/report', [ReportwarehouseController::class, 'report'])->name('warehouse.report');

    Route::get('/warehouse/report/pdf', [ReportwarehouseController::class, 'exportPDF'])->name('warehouse.report.pdf');

    Route::get('/warehouse/report/excel', [ReportwarehouseController::class, 'exportExcel'])->name('warehouse.report.excel');
    Route::post('/warehouse/add-to-store', [ReportwarehouseController::class, 'addToStore'])->name('warehouse.add.to.store');
    Route::post('/warehouse/add-to-critical-list', [ReportwarehouseController::class, 'addToCriticalList'])->name('warehouse.add.to.critical.list');
    Route::get('/warehouse/critical-list', [ReportwarehouseController::class, 'criticalList'])->name('warehouse.critical.list');
    Route::post('/warehouse/delete-from-critical-list', [ReportwarehouseController::class, 'deleteFromCriticalList']);


    // Critical list PDF export only
    Route::get('/warehouse/critical-list/pdf', [ReportwarehouseController::class, 'exportCriticalListPdf'])->name('warehouse.critical.list.pdf');
    Route::get("/delete-invoice", function () {
        return view("items.delete-invoice");
    })->name('delete-invoice');

    // Invoice routes
    Route::post('/get-invoices', [InvoiceController::class, 'getInvoices']);
    Route::get('/invoice/{id}', [InvoiceController::class, 'getInvoice']);

    Route::post('/update-invoice-item-quantity', [InvoiceController::class, 'updateInvoiceItemQuantity'])
        ->name('update-invoice-item-quantity');
    Route::post('/returns/delete-invoice', [InvoiceController::class, 'deleteInvoice']);
    Route::get('/invoice-stats', [InvoiceController::class, 'getInvoiceStats']);


    Route::middleware(['auth', 'role:admin'])->group(function () {

        Route::get("/reports.overview", function () {
            return view("items.report.reports-overview");
        })->name('reports.overview');

    });


    Route::get("/report-warehouse", function () {
        return view("items.report.report-warehouse");
    })->name('reportswarehouse');

    Route::get("/sales-reports", function () {
        return view("items.report.sales-reports");
    })->name('sales-reports.index');

    // Profit Report Routes
    Route::get('/profit-report/data', [App\Http\Controllers\Report\ProfitReportController::class, 'getProfitReport'])->name('profit.report.data');
    Route::get('/profit-report/cashiers', [App\Http\Controllers\Report\ProfitReportController::class, 'getCashiers'])->name('profit.report.cashiers');
    Route::get('/profit-report/invoice/{id}', [App\Http\Controllers\Report\ProfitReportController::class, 'getInvoiceDetails'])->name('profit.report.invoice');
    Route::get('/profit-report/export-pdf', [App\Http\Controllers\Report\ProfitReportController::class, 'exportPDF'])->name('profit.report.export-pdf');


    Route::get('/returns-report', [ReturnReportController::class, 'index'])->name('returns.report.page');
    Route::get('/returns/report', [ReturnReportController::class, 'returnsReport'])->name('returns.report.data');
    Route::get('/returns/detail/{id}', [ReturnReportController::class, 'returnDetail'])->name('returns.detail');
    Route::get('/returns/export', [ReturnReportController::class, 'exportReturnsReport'])->name('returns.export');


    Route::get("/reports-Loans-items", function () {
        return view("items.report.reports-loans");
    })->name('reports.loans');


    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    */

    // ڕوتەکانی قەرزەکان



Route::prefix('companiess')->group(function () {
    Route::get('/list', [brandController::class, 'listb'])->name('brands.list');
    Route::get('/search', [brandController::class, 'searchb'])->name('brands.search');
    Route::post('/store', [brandController::class, 'storeb'])->name('brands.store');
    Route::post('/update', [brandController::class, 'updateb'])->name('brands.update');
    Route::delete('/{id}', [brandController::class, 'destroyb'])->name('brands.destroy');
});




Route::get('/brands-page', function () {
    return view('items.brand');
})->name('brands.page');

    Route::prefix('debtors')->name('debtors.')->group(function () {
       
        Route::get('/', function () {
            return view('debtors.index');
        })->name('index');
        Route::get('/save-products', function () {
            return view('items.debtor-save-products');
        })->name('save-products');
        Route::get('/{id}', [ReportLoanController::class, 'showDebtor'])->name('show');
        Route::post('/pay', [ReportLoanController::class, 'makePayment'])->name('pay');
        Route::get('/payment-history', [ReportLoanController::class, 'getPaymentHistory'])->name('payment-history');
        Route::delete('/{id}/delete', [ReportLoanController::class, 'destroyDebtor'])->name('delete');
    });


    // Company Debts Routes
    Route::prefix('company-debts')->name('company.debts.')->group(function () {
        Route::get('/', [CompanyDebtController::class, 'index'])->name('index');
        Route::get('/list', [CompanyDebtController::class, 'list'])->name('list');
        Route::post('/', [CompanyDebtController::class, 'store'])->name('store');
        Route::put('/{id}', [CompanyDebtController::class, 'update'])->name('update');
        Route::delete('/{id}', [CompanyDebtController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/payment', [CompanyDebtController::class, 'addPayment'])->name('payment');
    });


    // List users
    Route::get('/users/list', function (Request $request) {
        $search = $request->get('search', '');

        $users = DB::table('users')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json(['success' => true, 'users' => $users]);
    })->name('users.list');

    // Store user
    Route::post('/users/store', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:1,2',
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'بەکارهێنەر زیادکرا']);
    })->name('users.store');

    // Update user
    Route::put('/users/{id}', function (Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:1,2',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'updated_at' => now(),
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        return response()->json(['success' => true, 'message' => 'بەکارهێنەر نوێکرایەوە']);
    });

    // Delete user
    Route::delete('/users/{id}', function ($id) {
        DB::table('users')->where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'بەکارهێنەر سڕایەوە']);
    });

    // Bulk delete
    Route::post('/users/bulk/delete', function (Request $request) {
        $ids = $request->ids;
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ بەکارهێنەرێک هەڵنەبژێردرا']);
        }

        DB::table('users')->whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => count($ids) . ' بەکارهێنەر سڕانەوە']);
    })->name('users.bulk.delete');

    // Bulk change role
    Route::post('/users/bulk/role', function (Request $request) {
        $ids = $request->ids;
        $role = $request->role;

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'هیچ بەکارهێنەرێک هەڵنەبژێردرا']);
        }

        DB::table('users')->whereIn('id', $ids)->update([
            'role' => $role,
            'updated_at' => now()
        ]);

        return response()->json(['success' => true, 'message' => 'ڕۆڵی بەکارهێنەران گۆڕدرا']);
    })->name('users.bulk.role');

    Route::post('/stock-products', [StockItemController::class, "store"])->name('stock-products.store');


    Route::get("/report-stock", function () {
        return view("items.report.report-stock");
    })->name('report-stock.index');

    Route::get('/stock-products/report', [StockProductController::class, 'reportStock'])->name('stock-products.report');


    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get("/create-daily-accounting", function () {
            return view("items.report.CreateDailyAccounting");
        })->name('create.daily.accounting');
    });


    Route::get("/reports-return-items", function () {
        return view("items.report.reports-return-items");
    })->name('reports.reports-return-items');

    Route::middleware(['auth', 'role:admin'])->group(function () {

        Route::get("/withdrawals", function () {
            return view("items.withdrawals");
        })->name('items-withdrawals.index');

    });

    Route::get(("/CompanyDebt"), function () {
        return view("items.CompanyDebt");
    })->name('CompanyDebt.index');


    Route::put('/withdraw/{id}', [App\Http\Controllers\WithdrawController::class, 'update'])->name('withdraw.update');
    Route::delete('/withdraw/{id}', [App\Http\Controllers\WithdrawController::class, 'destroy'])->name('withdraw.destroy');


    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get(("/setting"), function () {
            return view("items.setting");
        })->name('setting');
    });
    
    
    
});


Route::post('/seller/store', [SellerController::class, 'store'])->name('seller.store');
    
Route::get('/sellers/list', [SellerController::class, 'list'])->name('sellers.list');

Route::get('/sellers/listt', [SellerController::class, 'listt'])->name('sellers.list');
Route::post('/sellers/storee', [SellerController::class, 'storee'])->name('sellers.store');

Route::get('/sellers', [SellerController::class, 'index'])->name('sellers.index');

// API

Route::post('/sellers/update', [SellerController::class, 'update'])->name('sellers.update');
Route::delete('/sellers/{id}/delete', [SellerController::class, 'destroy'])->name('sellers.destroy');
Route::get('/sellers/{id}/products', [SellerController::class, 'products'])->name('sellers.products');



Route::middleware(['auth'])->group(function () {
    Route::get('/withdrawals/show', [WithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('/withdrawals/save', [WithdrawController::class, 'store'])->name('withdraw.store');
    Route::get('/withdrawals/history', [WithdrawController::class, 'index'])->name('withdraw.history');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';