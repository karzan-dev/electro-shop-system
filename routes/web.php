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


Route::get('/', function () {
        return redirect()->route('login');
    });




Route::middleware('auth')->group(function () {


Route::get('/dashboard', function(){

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

Route::post('/update',[ProductController::class,"update"])->name('products.update');

Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
// Company routes
Route::get('/companies/list', [ProductController::class, 'getCompaniesList'])->name('companies.list');
Route::post('/companies/store', [ProductController::class, 'store'])->name('companies.store');


Route::get('/get-data/Casher', [CasherController::class, 'getData'])->name('casher.getData');

Route::get('/get-casher-details/{id}', [CasherController::class, 'index'])->name('casher.getDetails');


Route::get('/casher/getData', [CreateDailyAccountingController::class, 'getData'])->name('casher.getDataDetails');
Route::get('/get-casher-details/{id}', [CreateDailyAccountingController::class, 'getDetails'])->name('casher.details');

// Invoice Routes
Route::get('/get-invoices/Details', [CreateDailyAccountingController::class, 'getInvoices'])->name('invoicesDetails.get');
Route::get('/invoice/Details/{id}', [CreateDailyAccountingController::class, 'show'])->name('invoiceDetails.show');


Route::get("/items-loans", function () {
        return view("items.items-loans");

    })->name('items-loans.index');


  Route::get('/debtors', [LoanController::class, 'index'])->name('debtors.index');
    Route::get('/debtors/list', [LoanController::class, 'getDebtorsList'])->name('debtors.list');
    Route::get('/debtors/{id}/show', [LoanController::class, 'showDebtor'])->name('debtors.show');
    Route::post('/debtors/pay', [LoanController::class, 'makePayment'])->name('debtors.pay');
    Route::get('/debtors/invoice/{loanId}', [LoanController::class, 'viewInvoice'])->name('debtors.invoice');
    Route::post('/debtors/return-item/{loanId}', [LoanController::class, 'returnItem'])->name('debtors.return-item');

    Route::get('/debtors/save-products',function(Request $request){
        return view("items.debtor-save-products");
    })->name('debtors.save-products');

    Route::post('/debtors/save', [DebtorController::class, 'debtors_save'])->name('debtors.save');
    // Route بۆ گەڕانی کڕیار
Route::post('/customers/search', function(Request $request) {

    $searchTerm = $request->input('search_term');

    $customers = DB::table('customer')
        ->select('id', 'name', 'number_phone', 'address')
        ->where(function($q) use ($searchTerm) {
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

Route::post('/products/search-debtors', function(Request $request)
{
    $term = $request->search_term;

    $products = DB::table('private_goods')
        ->where(function($q) use ($term) {
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


Route::post('/returns/store', [ReturnItemController::class, 'store']);;


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

// لە فایلی routes/web.php

// ڕاوتەکانی تر...

Route::get('/sales/next-voucher-number', [SaleController::class, 'getNextVoucherNumber'])->name('sales.get-next-voucher');

route::post('/return-item-store', [ReturnItemController::class, 'store'])->name('sales.print');
Route::post('/returns/process-return', [ReturnItemController::class, 'processReturn'])->name('returns.process-return');


Route::get("/Stock-Item", function () {
        return view("items.items-stock");

    })->name('stock.index');



Route::post('/products/search-by-barcode-sells', [ReturnItemController::class, 'searchByBarcode'])->name('products.searchByBarcode-sells');

Route::post('/products/search-by-name-sells', [ReturnItemController::class, 'searchByName'])->name('products.searchByName-sells');

Route::post('/returns/search-by-invoice', [ReturnItemController::class, 'searchByInvoice'])->name('returns.search.invoice');

Route::get("/sales-credit", function () {
        return view("items.items-sales-credit");

    })->name('sales-credit.index');


Route::get("/Casher-coin", function () {
        return view("items.casher-coin");

    })->name('Casher-coin');

Route::post('/casher-coin/store', [CasherController::class, 'store'])->name('casher.store');


Route::post('/credit-sales/store', [LoanController::class, 'store']);


Route::get("/create-barcode", function () {
        return view("items.create-barcode");

    })->name('create-barcode');


Route::get("/reports-warehouse", function () {
        return view("items.report.reports-warehouse");

    })->name('reports-warehouse');


Route::get('/warehouse/report', [ReportwarehouseController::class, 'report'])->name('warehouse.report');

Route::get('/warehouse/report/pdf', [ReportwarehouseController::class, 'exportPDF'])->name('warehouse.report.pdf');

Route::get('/warehouse/report/excel', [ReportwarehouseController::class, 'exportExcel'])->name('warehouse.report.excel');
Route::post('/warehouse/add-to-store', [ReportwarehouseController::class, 'addToStore'])->name('warehouse.add.to.store');
Route::post('/warehouse/add-to-critical-list', [ReportwarehouseController::class, 'addToCriticalList'])->name('warehouse.add.to.critical.list');
Route::get('/warehouse/critical-list', [ReportwarehouseController::class, 'criticalList'])->name('warehouse.critical.list');



// Critical list PDF export only
Route::get('/warehouse/critical-list/pdf', [ReportwarehouseController::class, 'exportCriticalListPdf'])->name('warehouse.critical.list.pdf');
Route::get("/delete-invoice", function () {
        return view("items.delete-invoice");

    })->name('delete-invoice');

// Invoice routes



Route::post('/get-invoices', [InvoiceController::class, 'getInvoices']);
Route::get('/invoice/{id}', [InvoiceController::class, 'getInvoice']);
Route::post('/returns/delete-invoice', [InvoiceController::class, 'deleteInvoice']);
Route::get('/invoice-stats', [InvoiceController::class, 'getInvoiceStats']);







});
Route::post('/stock-products',[StockItemController::class,"store"])->name('stock-products.store');



Route::get("/create-daily-accounting", function () {
        return view("items.report.CreateDailyAccounting");

    })->name('create.daily.accounting');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
