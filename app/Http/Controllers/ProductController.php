<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * ✅ ڕێگەی فیزیکی بۆ فۆڵدەری وێنەکان
     */
    private function getImageDirectory()
    {
        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/images/products';

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        return $destinationPath;
    }

    /**
     * ✅ ناونیشانی وێنە بۆ DB
     */
    private function getImagePath($imageName)
    {
        return '/images/products/' . $imageName;
    }

    // ============================================================
    // STORE — زیادکردنی کاڵای نوێ (لەگەڵ Auto-create کۆمپانیا)
    // ============================================================
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'تکایە ناوی کاڵا داخڵ بکە',
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|max:50',
            'seller' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_id' => 'nullable|integer|exists:companies,id',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'minimum_wearhouse' => 'nullable|integer|min:0',
        ], $messages);

        $imageName = null;
        $imagePath = null;

        // 📸 Upload Image
        if ($request->hasFile('image_product_camera') && $request->file('image_product_camera')->isValid()) {
            $destinationPath = $this->getImageDirectory();

            $extension = $request->image_product_camera->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $request->image_product_camera->move($destinationPath, $imageName);

            $imagePath = $this->getImagePath($imageName);
        }

        // ============================================================
        // 🏢 چارەسەری کۆمپانیا — Auto-create ئەگەر نەبوو
        // ============================================================
        $companyId = null;

        // 1️⃣ ئەگەر company_id لە فۆرمەوە هاتووە
        if (!empty($validated['company_id'])) {
            $companyId = $validated['company_id'];

        // 2️⃣ ئەگەر company_name هاتووە بەڵام company_id نییە
        } elseif (!empty($validated['company_name'])) {
            $companyName = trim($validated['company_name']);

            // 🔍 پشکنین ئەگەر پێشتر هەیە (case-insensitive)
            $existingCompany = DB::table('companies')
                ->whereRaw('LOWER(company_name) = ?', [mb_strtolower($companyName)])
                ->first();

            if ($existingCompany) {
                $companyId = $existingCompany->id;
            } else {
                // 🆕 نییە → تۆماری بکە
                $companyId = DB::table('companies')->insertGetId([
                    'company_name' => $companyName,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        DB::beginTransaction();

        try {
            // ✅ INSERT products
            $productId = DB::table('products')->insertGetId([
                'name' => $validated['name'],
                'barcode' => $validated['barcode'],
                'company_id' => $companyId,
                'purchase_price' => $validated['purchase_price'] ?? 0,
                'selling_price' => $validated['selling_price'] ?? 0,
                'minimum_wearhouse' => $validated['minimum_wearhouse'] ?? 0,
                'image_product_camera' => $imageName,
                'image_producte_path' => $imagePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 🔄 Warehouse
            DB::table('product_wearhouse')->insert([
                'id_product' => $productId,
                'counter' => $validated['minimum_wearhouse'] ?? 0
            ]);

            // 👤 تۆمارکردنی فرۆشیار
            $seller = trim($validated['seller']);
            $voucher = DB::table('Vouchers')
                ->where('voucher_name', $seller)
                ->first();

            if ($voucher) {
                $lastVoucherId = $voucher->id;
            } else {
                $lastVoucherId = DB::table('Vouchers')->insertGetId([
                    'voucher_name' => $seller,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('N_Vouchers')->insert([
                'Voucher_id' => $lastVoucherId,
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                "seller" => $validated['seller'],
                "data" => $lastVoucherId,
                'success' => true,
                'product_id' => $productId,
                'company_id' => $companyId,
                'image_url' => $imagePath ? asset($imagePath) : null,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'هەڵە لە تۆمارکردن: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ============================================================
    // UPDATE — نوێکردنەوەی کاڵا (لەگەڵ Auto-create کۆمپانیا)
    // ============================================================
 public function update(Request $request)
{
    $product = DB::table('products')->where('id', $request->id)->first();

    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => 'کاڵا نەدۆزرایەوە'
        ], 404);
    }

    $request->validate(
        [
            'new_barcode'  => 'required|string',
            'voucher_name' => 'nullable|string|max:255',
            'company'      => 'nullable|string|max:255',   // ⭐ ناوی کۆمپانیا لە Blade
            'company_name' => 'nullable|string|max:255',   // ⭐ پشتگیری
            'company_id'   => 'nullable|integer|exists:companies,id',
        ],
        [
            'new_barcode.required' => 'تکایە بارکۆد بنووسە',
        ]
    );

    $imageName = $product->image_product_camera;
    $imagePath = $product->image_producte_path;
    $destinationPath = $this->getImageDirectory();

    // ============================================================
    // 📸 بەڕێوەبردنی وێنە
    // ============================================================
    if ($request->hasFile('image_product_camera') && $request->file('image_product_camera')->isValid()) {
        if ($product->image_producte_path) {
            $oldFile = $_SERVER['DOCUMENT_ROOT'] . $product->image_producte_path;
            if (file_exists($oldFile)) unlink($oldFile);
        }
        $extension = $request->image_product_camera->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $extension;
        $imagePath = $this->getImagePath($imageName);
        $request->image_product_camera->move($destinationPath, $imageName);

    } elseif ($request->filled('captured_image') && $request->image_source_type == 'camera') {
        if ($product->image_producte_path) {
            $oldFile = $_SERVER['DOCUMENT_ROOT'] . $product->image_producte_path;
            if (file_exists($oldFile)) unlink($oldFile);
        }
        $imageName = time() . '_' . uniqid() . '.jpg';
        $imagePath = $this->getImagePath($imageName);
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $request->captured_image);
        $imageData = str_replace(' ', '+', $imageData);
        file_put_contents($destinationPath . '/' . $imageName, base64_decode($imageData));

    } elseif ($request->has('remove_image') && $request->remove_image == 'true') {
        if ($product->image_producte_path) {
            $oldFile = $_SERVER['DOCUMENT_ROOT'] . $product->image_producte_path;
            if (file_exists($oldFile)) unlink($oldFile);
        }
        $imageName = null;
        $imagePath = null;
    }

    // ============================================================
    // 🏢 چارەسەری کۆمپانیا — تەنها لە Controller
    // ============================================================
    // Logic:
    //   1. ئەگەر company_id هاتووە → بەکاریبهێنە
    //   2. ئەگەر company یان company_name هاتووە → پشکنین و دۆزینەوەی id
    //   3. ئەگەر هیچ نەبوو → company_id ی ئێستا پارێزراوە
    // ============================================================
    
    $companyId = $product->company_id; // default

    if ($request->filled('company_id')) {
        // ✅ ئەگەر JS id ی ڕاستی ناردووە → بەکاریبهێنە
        $companyId = $request->company_id;

    } else {
        // 🔍 ناوەکە وەربگرە (لە 'company' یان 'company_name')
        $companyName = trim($request->input('company_name') ?? $request->input('company') ?? '');

        if ($companyName !== '') {
            // 🔍 پشکنین بە case-insensitive
            $existingCompany = DB::table('companies')
                ->whereRaw('LOWER(company_name) = ?', [mb_strtolower($companyName)])
                ->first();

            if ($existingCompany) {
                // ✅ هەیە → id ی بەکاربهێنە
                $companyId = $existingCompany->id;
            } else {
                // 🆕 نییە → تۆماری بکە
                $companyId = DB::table('companies')->insertGetId([
                    'company_name' => $companyName,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }
        // ئەگەر companyName بەتاڵ بێت → companyId وەک خۆی دەمێنێتەوە
    }

    // ============================================================
    // 👤 پشکنینی ناوی فرۆشیار
    // ============================================================
    $voucher = null;
    $voucherName = $request->filled('voucher_name')
        ? trim($request->voucher_name)
        : null;

    if ($voucherName !== null && $voucherName !== '') {
        $voucher = DB::table('Vouchers')
            ->where('voucher_name', $voucherName)
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'ناوی فرۆشیار نەدۆزرایەوە',
            ], 422);
        }
    }

    DB::beginTransaction();

    try {
        // Update products
        DB::table('products')->where('id', $product->id)->update([
            'barcode'              => $request->new_barcode,
            'name'                 => $request->name ?? $product->name,
            'company_id'           => $companyId,   // ⭐ گۆڕدرا
            'purchase_price'       => $request->purchase_price ?? $product->purchase_price,
            'selling_price'        => $request->selling_price ?? $product->selling_price,
            'minimum_wearhouse'    => $request->minimum_wearhouse ?? $product->minimum_wearhouse,
            'image_product_camera' => $imageName,
            'image_producte_path'  => $imagePath,
            'updated_at'           => now(),
        ]);

        // Warehouse
        $warehouseExists = DB::table('product_wearhouse')
            ->where('id_product', $product->id)
            ->exists();

        if ($warehouseExists) {
            DB::table('product_wearhouse')
                ->where('id_product', $product->id)
                ->update([
                    'counter' => $request->minimum_wearhouse ?? 0,
                ]);
        } else {
            DB::table('product_wearhouse')->insert([
                'id_product' => $product->id,
                'counter'    => $request->minimum_wearhouse ?? 0,
            ]);
        }

        // N_Vouchers
        if ($voucher) {
            $existingNVoucher = DB::table('N_Vouchers')
                ->where('product_id', $product->id)
                ->first();

            if ($existingNVoucher) {
                DB::table('N_Vouchers')
                    ->where('id', $existingNVoucher->id)
                    ->update([
                        'Voucher_id' => $voucher->id,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('N_Vouchers')->insert([
                    'product_id' => $product->id,
                    'Voucher_id' => $voucher->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'هەڵە لە تۆمارکردن: ' . $e->getMessage(),
        ], 500);
    }

    // ⭐ وەرگرتنی زانیاری نوێکراوە لەگەڵ ناوی کۆمپانیا
    $updatedProduct = DB::table('products as p')
        ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
        ->where('p.id', $product->id)
        ->select('p.*', 'c.company_name')
        ->first();

    return response()->json([
        'success'      => true,
        'message'      => 'کاڵا بە سەرکەوتوویی نوێ کرایەوە',
        'product'      => $updatedProduct,
        'company_id'   => $companyId,
        'company_name' => $updatedProduct->company_name ?? null,
        'image_url'    => $imagePath ? asset($imagePath) : null,
    ]);
}
    // ============================================================
    // DESTROY — سڕینەوەی کاڵا
    // ============================================================
    public function destroy(Request $request, $id)
    {
        try {
            $product = DB::table('products')->where('id', $id)->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'کاڵا نەدۆزرایەوە!'
                ], 404);
            }

            if (!empty($product->image_producte_path)) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $product->image_producte_path;
                if (file_exists($filePath)) unlink($filePath);
            }

            DB::table('products')->where('id', $id)->delete();
            DB::table('product_wearhouse')->where('id_product', $id)->delete();
            DB::table('N_Vouchers')->where('product_id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'کاڵاکە بە سەرکەوتوویی سڕایەوە!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // INDEX
    // ============================================================
    public function index()
    {
        $products = DB::table('products')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('items.items-edit', compact('products'));
    }

    // ============================================================
    // GET PRODUCTS LIST
    // ============================================================
public function getProductsList(Request $request)
{
    // ═══════════════════════════════════════════════════════
    //  Subquery بۆ وەرگرتنی ڤاوچەرەکان وەک JSON array
    // ═══════════════════════════════════════════════════════
    $vouchersSubquery = DB::table('N_Vouchers as nv')
        ->join('Vouchers as v', 'v.id', '=', 'nv.Voucher_id')
        ->select(
            'nv.product_id',
            DB::raw("JSON_ARRAYAGG(
                JSON_OBJECT(
                    'n_voucher_id', nv.id,
                    'voucher_id', nv.Voucher_id,
                    'voucher_name', v.voucher_name
                )
            ) as vouchers")
        )
        ->groupBy('nv.product_id');

    $query = DB::table('products as p')
        ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
        ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
        ->leftJoinSub($vouchersSubquery, 'vch', function ($join) {
            $join->on('vch.product_id', '=', 'p.id');
        })
        ->select(
            'p.id',
            'p.barcode',
            'p.name',
            'p.selling_price',
            'p.purchase_price',
            'p.company_id',
            'c.company_name',
            'p.image_producte_path',
            'pw.counter',
            'vch.vouchers'
        );

    // ═══════════════════════════════════════════════════════
    //  Filters
    // ═══════════════════════════════════════════════════════
    if ($request->filled('barcode')) {
        $query->where('p.barcode', 'like', '%' . $request->barcode . '%');
    }

    if ($request->filled('name')) {
        $query->where('p.name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('company_id')) {
        $query->where('p.company_id', $request->company_id);
    }

    $query->orderBy('p.created_at', 'desc');

    // ═══════════════════════════════════════════════════════
    //  Pagination — ئێستا هەر بەرهەمێک تەنها یەک جار
    // ═══════════════════════════════════════════════════════
    $products = $query->paginate(15);

    // ═══════════════════════════════════════════════════════
    //  Decode JSON vouchers بۆ Array
    // ═══════════════════════════════════════════════════════
    $products->getCollection()->transform(function ($product) {
        $product->vouchers = $product->vouchers
            ? json_decode($product->vouchers, true)
            : [];
        return $product;
    });

    return response()->json([
        'success' => true,
        'products' => $products
    ]);
}

    // ============================================================
    // GET COMPANIES LIST
    // ============================================================
    public function getCompaniesList()
    {
        $companies = DB::table('companies')
            ->select('id', 'company_name as company')
            ->whereNotNull('company_name')
            ->where('company_name', '!=', '')
            ->orderBy('company_name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'companies' => $companies
        ]);
    }
    
    
    
// ============================================================
// ✅ SEARCH COMPANIES — بۆ گەڕانی کۆمپانیا (بۆ autocomplete)
// ============================================================
// ============================================================
// ✅ LIST — لیستی کاڵاکان بە فلتەر (کۆمپانیا + فرۆشیار)
// ============================================================
// ============================================================
// ✅ LIST — لیستی کاڵاکان بە فلتەر (کۆمپانیا + فرۆشیار)
// ============================================================
public function list(Request $request)
{
    $query = DB::table('products as p')
        ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
        ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
        ->select(
            'p.id',
            'p.barcode',
            'p.name',
            'p.selling_price',
            'p.purchase_price',
            'p.company_id',
            'c.company_name',
            'p.image_producte_path',
            'p.image_product_camera',
            'pw.counter'
        );

    // ✅ فلتەری بارکۆد
    if ($request->filled('barcode')) {
        $query->where('p.barcode', 'LIKE', '%' . trim($request->barcode) . '%');
    }

    // ✅ فلتەری ناوی کاڵا
    if ($request->filled('name')) {
        $query->where('p.name', 'LIKE', '%' . trim($request->name) . '%');
    }

    // ✅ فلتەری کۆمپانیا — بە company_name
    if ($request->filled('company')) {
        $query->where('c.company_name', 'LIKE', '%' . trim($request->company) . '%');
    }

    // ✅ فلتەری فرۆشیار — بە JOIN ی جیاواز
    if ($request->filled('voucher')) {
        $voucherSearch = trim($request->voucher);
        
        // Subquery بۆ فلتەری فرۆشیار (بەبێ دووبارەبوونەوە)
        $query->whereExists(function ($subQuery) use ($voucherSearch) {
            $subQuery->select(DB::raw(1))
                ->from('N_Vouchers as nv')
                ->join('Vouchers as v', 'v.id', '=', 'nv.Voucher_id')
                ->whereColumn('nv.product_id', 'p.id')
                ->where('v.voucher_name', 'LIKE', '%' . $voucherSearch . '%');
        });
    }

    $query->orderBy('p.created_at', 'desc');

    $products = $query->paginate(15);

    // ⭐ زیادکردنی voucher_name بۆ هەر کاڵایەک (لە دوای paginate)
    $products->getCollection()->transform(function ($product) {
        // وەرگرتنی ڤاوچەری یەکەم بۆ ئەم کاڵایە
        $voucher = DB::table('N_Vouchers as nv')
            ->join('Vouchers as v', 'v.id', '=', 'nv.Voucher_id')
            ->where('nv.product_id', $product->id)
            ->select('v.voucher_name')
            ->first();

        $product->voucher_name = $voucher->voucher_name ?? null;
        return $product;
    });

    return response()->json([
        'success'  => true,
        'products' => $products,
    ]);
}


// ============================================================
// ✅ SEARCH COMPANIES — گەڕان بۆ کۆمپانیا (بۆ autocomplete)
// ============================================================
public function searchCompanies(Request $request)
{
    try {
        $query = trim($request->input('q', ''));

        if ($query === '') {
            $companies = DB::table('companies')
                ->select('id', 'company_name')
                ->whereNotNull('company_name')
                ->where('company_name', '!=', '')
                ->orderBy('company_name', 'asc')
                ->limit(10)
                ->get();

            return response()->json([
                'success'   => true,
                'companies' => $companies,
                'total'     => $companies->count(),
            ]);
        }

        $companies = DB::table('companies')
            ->select('id', 'company_name')
            ->whereNotNull('company_name')
            ->where('company_name', '!=', '')
            ->where('company_name', 'LIKE', '%' . $query . '%')
            ->orderByRaw("CASE 
                WHEN company_name LIKE ? THEN 1 
                WHEN company_name LIKE ? THEN 2 
                ELSE 3 
            END", [$query . '%', '%' . $query . '%'])
            ->orderBy('company_name', 'asc')
            ->limit(15)
            ->get();

        return response()->json([
            'success'   => true,
            'companies' => $companies,
            'total'     => $companies->count(),
            'query'     => $query,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'هەڵە لە گەڕان: ' . $e->getMessage(),
        ], 500);
    }
}

    // ============================================================
    // SEARCH BY NAME
    // ============================================================
    public function searchByName(Request $request)
    {
        try {
            $searchTerm = $request->input('name');

            if (empty($searchTerm) || strlen(trim($searchTerm)) < 2) {
                return response()->json([
                    'success' => true,
                    'products' => []
                ]);
            }

            $searchTerm = trim($searchTerm);
            $searchParam = "%{$searchTerm}%";

            $products = DB::table('products as p')
                ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
                ->select(
                    'p.id',
                    'p.name',
                    'p.company_id',
                    'c.company_name',
                    'p.barcode',
                    'p.image_product_camera',
                    'p.image_producte_path',
                    'p.purchase_price',
                    'p.selling_price',
                    'p.minimum_wearhouse',
                    'pw.counter'
                )
                ->where(function ($query) use ($searchParam) {
                    $query->where('p.name', 'LIKE', $searchParam)
                          ->orWhere('c.company_name', 'LIKE', $searchParam);
                })
                ->orderBy('p.name')
                ->limit(10)
                ->get();

            $productsArray = $products->map(function ($product) {
                return [
                    'id' => $product->id ?? null,
                    'name' => $product->name ?? '',
                    'company_id' => $product->company_id ?? null,
                    'company_name' => $product->company_name ?? '',
                    'barcode' => $product->barcode ?? '',
                    'image_product_camera' => $product->image_product_camera ?? '',
                    'image_producte_path' => $product->image_producte_path ?? '',
                    'image_url' => $product->image_producte_path
                        ? asset($product->image_producte_path)
                        : null,
                    'purchase_price' => $product->purchase_price ?? null,
                    'selling_price' => $product->selling_price ?? null,
                    'minimum_wearhouse' => $product->minimum_wearhouse ?? null,
                    'counter' => $product->counter ?? null,
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'products' => $productsArray
            ]);

        } catch (\Exception $e) {
            Log::error('Error in searchByName: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'هەڵەی ناوەخۆیی سێرڤەر',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // SEARCH BY NAME (ee)
    // ============================================================
  public function searchByNameee(Request $request)
{
    $searchTerm = $request->input('search_term');

    if (!$searchTerm || strlen(trim($searchTerm)) < 2) {
        return response()->json([
            'success' => true,
            'products' => []
        ]);
    }

    $searchWildcard = '%' . trim($searchTerm) . '%';

    $products = DB::table('products as p')
        ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
        ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
        ->leftJoin('N_Vouchers as nv', 'nv.product_id', '=', 'p.id')       // ⭐ زیادکرا
        ->leftJoin('Vouchers as v', 'v.id', '=', 'nv.Voucher_id')          // ⭐ زیادکرا
        ->where('p.name', 'LIKE', $searchWildcard)
        ->select(
            'p.id',
            'p.barcode',
            'p.name',
            'p.selling_price',
            'p.purchase_price',
            'p.company_id',
            'c.company_name',
            'v.voucher_name',                                               // ⭐ زیادکرا
            'p.image_producte_path',
            'pw.counter'
        )
        ->groupBy(                                                          // ⭐ زیادکرا
            'p.id',
            'p.barcode',
            'p.name',
            'p.selling_price',
            'p.purchase_price',
            'p.company_id',
            'c.company_name',
            'v.voucher_name',
            'p.image_producte_path',
            'pw.counter'
        )
        ->limit(10)
        ->get();

    $formattedProducts = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'barcode' => $product->barcode,
            'name' => $product->name,
            'selling_price' => (float) $product->selling_price,
            'price' => (float) $product->selling_price,
            'purchase_price' => (float) ($product->purchase_price ?? 0),
            'company_id' => $product->company_id,
            'company_name' => $product->company_name ?? 'بێ کۆمپانیا',
            'voucher_name' => $product->voucher_name ?? null,               // ⭐ زیادکرا
            'image_producte_path' => $product->image_producte_path,
            'image_url' => $product->image_producte_path
                ? asset($product->image_producte_path)
                : null,
            'counter' => (int) ($product->counter ?? 0)
        ];
    });

    return response()->json([
        'success' => true,
        'products' => $formattedProducts
    ]);
}
    // ============================================================
    // SEARCH BY BARCODE
    // ============================================================
    public function searchByBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $searchTerm = $request->input('search_term');

        if ($searchTerm) {
            $products = DB::table('products as p')
                ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
                ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
                ->where('p.barcode', 'LIKE', "%{$searchTerm}%")
                ->orWhere('p.name', 'LIKE', "%{$searchTerm}%")
                ->select('p.*', 'pw.counter', 'c.company_name')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        }

        $product = DB::table('products as p')
            ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
            ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
            ->where('p.barcode', $barcode)
            ->select('p.*', 'pw.counter', 'c.company_name')
            ->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'کاڵا نەدۆزرایەوە'
        ], 404);
    }

    // ============================================================
    // SEARCH BY BARCODES
    // ============================================================
    public function searchByBarcodess(Request $request)
    {
        $barcode = $request->input('barcode');
        $companyId = $request->input('company_id');

        $query = DB::table('products as p')
            ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
            ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
            ->where('p.barcode', $barcode);

        if ($companyId) {
            $query->where('p.company_id', $companyId);
        }

        $products = $query->select(
            'p.id',
            'p.barcode',
            'p.name',
            'p.selling_price',
            'p.purchase_price',
            'p.company_id',
            'c.company_name',
            'p.image_producte_path',
            'pw.counter'
        )->get();

        if ($products->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'کاڵا نەدۆزرایەوە'
        ], 404);
    }

    // ============================================================
    // BY BARCODE
    // ============================================================
    public function ByBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $searchTerm = $request->input('search_term');

        $query = DB::table('products as p')
            ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
            ->leftJoin('companies as c', 'c.id', '=', 'p.company_id');

        if ($searchTerm && strlen(trim($searchTerm)) >= 1) {
            $query->where('p.barcode', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('p.name', 'LIKE', "%{$searchTerm}%");
        } elseif ($barcode) {
            $query->where('p.barcode', $barcode);
        }

        $products = $query->select('p.*', 'pw.counter', 'c.company_name')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    // ============================================================
    // AUTOCOMPLETE
    // ============================================================
    public function autocomplete(Request $request)
    {
        try {
            $type = $request->input('type');
            $query = $request->input('query');

            if (empty($query) || strlen(trim($query)) < 1) {
                return response()->json([
                    'success' => true,
                    'results' => []
                ]);
            }

            $searchTerm = '%' . trim($query) . '%';
            $results = [];

            if ($type == 'barcode') {
                $results = DB::table('products')
                    ->where('barcode', 'LIKE', $searchTerm)
                    ->select('barcode', 'name')
                    ->limit(10)
                    ->get();

            } elseif ($type == 'name') {
                $results = DB::table('products')
                    ->where('name', 'LIKE', $searchTerm)
                    ->select('name', 'barcode', 'company_id')
                    ->limit(10)
                    ->get();

            } elseif ($type == 'company') {
                $results = DB::table('companies')
                    ->where('company_name', 'LIKE', $searchTerm)
                    ->select('id as company_id', 'company_name as company')
                    ->limit(10)
                    ->get();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid type parameter'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'results' => $results
            ]);

        } catch (\Exception $e) {
            Log::error('Autocomplete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // EDIT
    // ============================================================
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // ============================================================
    // GET PRODUCT BY BARCODE
    // ============================================================
    public function getProductByBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string'
        ]);

        $products = DB::table('products as p')
            ->leftJoin('companies as c', 'c.id', '=', 'p.company_id')
            ->where('p.barcode', $request->barcode)
            ->select(
                'p.id',
                'p.name',
                'p.barcode',
                'p.company_id',
                'c.company_name',
                'p.purchase_price',
                'p.selling_price',
                'p.minimum_wearhouse',
                'p.image_producte_path'
            )
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'exists' => false,
                'message' => 'بارکۆد نەدۆزرایەوە'
            ]);
        }

        $productIds = $products->pluck('id')->toArray();

        $warehouses = DB::table('product_wearhouse')
            ->whereIn('id_product', $productIds)
            ->get()
            ->keyBy('id_product');

        $productsList = [];
        foreach ($products as $product) {
            $warehouse = $warehouses->get($product->id);

            $productsList[] = [
                'id'                  => $product->id,
                'name'                => $product->name,
                'barcode'             => $product->barcode,
                'company_id'          => $product->company_id,
                'company_name'        => $product->company_name ?? 'بێ کۆمپانیا',
                'purchase_price'      => $product->purchase_price,
                'selling_price'       => $product->selling_price,
                'minimum_wearhouse'   => $product->minimum_wearhouse,
                'image_producte_path' => $product->image_producte_path,
                'image_url'           => $product->image_producte_path
                    ? asset($product->image_producte_path)
                    : null,
                'warehouse_counter'   => $warehouse->counter ?? 0,
                'has_stock'           => ($warehouse->counter ?? 0) > 0
            ];
        }

        return response()->json([
            'exists'      => true,
            'products'    => $productsList,
            'total_count' => count($productsList)
        ]);
    }
}