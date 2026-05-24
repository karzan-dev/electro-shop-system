<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{

public function store(Request $request)
{
    $messages = [
        'name.required' => 'تکایە ناوی کاڵا داخڵ بکە',
    ];

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'barcode' => 'required|string|max:50',
        'company' => 'nullable|string|max:255',
        'purchase_price' => 'nullable|numeric|min:0',
        'selling_price' => 'nullable|numeric|min:0',
        'minimum_wearhouse' => 'nullable|integer|min:0',
        'image_product_camera' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ], $messages);

    // 📸 Upload Image
    $imageName = null;
    $imagePath = null;

    if ($request->hasFile('image_product_camera')) {
           $imageName = time() . '_' . uniqid() . '.' . $request->image_product_camera->extension();
            $imagePath = 'images/products/' . $imageName;
            $request->image_product_camera->move(public_path('images/products'), $imageName);
    }

    // ✅ ALWAYS INSERT
    $productId = DB::table('products')->insertGetId([
        'name' => $validated['name'],
        'barcode' => $validated['barcode'],
        'company' => $validated['company'] ?? '',
        'purchase_price' => $validated['purchase_price'] ?? 0,
        'selling_price' => $validated['selling_price'] ?? 0,
        'minimum_wearhouse' => $validated['minimum_wearhouse'] ?? 0,
        'image_product_camera' => $imageName,
        'image_producte_path' => $imagePath,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 🔄 warehouse
    DB::table('product_wearhouse')->insert([
        'id_product' => $productId,
        'counter' => $validated['minimum_wearhouse'] ?? 0
    ]);

    return response()->json([
        'success' => true,
        'product_id' => $productId
    ]);
}


public function getCompaniesList()
{
    $companies = DB::table("products")->select("company")->distinct()->get();
    return response()->json([
        'success' => true,
        'companies' => $companies
    ]);
}

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
    
    // Search by product name only (without company filter)
    $products = DB::table('products as p')
        ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
        ->where('p.name', 'LIKE', $searchWildcard)
        ->select(
            'p.id',
            'p.barcode',
            'p.name',
            'p.selling_price',
            'p.purchase_price',
            'p.company',
            'p.image_producte_path',
            'pw.counter'
        )
        ->limit(10)
        ->get();
    
    // Format the response to match what the frontend expects
    $formattedProducts = $products->map(function($product) {
        return [
            'id' => $product->id,
            'barcode' => $product->barcode,
            'name' => $product->name,
            'selling_price' => (float) $product->selling_price,
            'price' => (float) $product->selling_price,  // Add price alias for frontend
            'purchase_price' => (float) ($product->purchase_price ?? 0),
            'company' => $product->company ?? 'بێ کۆمپانیا',
            'image_producte_path' => $product->image_producte_path,
            'counter' => (int) ($product->counter ?? 0)
        ];
    });
    
    return response()->json([
        'success' => true,
        'products' => $formattedProducts
    ]);
}


public function ByBarcode(Request $request){
    
        $barcode = $request->input('barcode');
        $searchTerm = $request->input('search_term');

        $query = DB::table('products as p')->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id');
            
            // ئەگەر search_term هەبوو، هەردووکیان بگەڕێ
            if ($searchTerm && strlen(trim($searchTerm)) >= 1) {
                $query->where('p.barcode', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('p.name', 'LIKE', "%{$searchTerm}%");
            }
            // ئەگەر barcode تەنها هەبوو، تەنها بارکۆد بگەڕێ
            elseif ($barcode) {
                $query->where('p.barcode', $barcode);
            }
            
            $products = $query->select('p.*', 'pw.counter')
                ->limit(10)
                ->get();
            
            return response()->json([
                'success' => true,
                'products' => $products
            ]);



}


public function searchByBarcodess(Request $request)
{
    $barcode = $request->input('barcode');
    $companyName = $request->input('company_name');
    
    // گەڕانی هەموو کاڵاکانی هەمان بارکۆد
    $query = DB::table('products as p')
        ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
        ->where('p.barcode', $barcode);
    
    // ئەگەر ناوی کۆمپانیا هات، تەنها ئەو کۆمپانیایە بگەڕێ
    if ($companyName) {
        $query->where('p.company', $companyName);
    }
    
    $products = $query->select(
        'p.id',
        'p.barcode',
        'p.name',
        'p.selling_price',
        'p.purchase_price',
        'p.company',
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




public function searchByBarcode(Request $request)
{
    $barcode = $request->input('barcode');
    $searchTerm = $request->input('search_term'); // For auto-complete searching
    
    // If search_term is provided (for auto-complete), return multiple results
    if ($searchTerm) {  // <-- ڕاستکراوە (ئەمەبوو: if ($search_term = $request->input('search_term')))
        $products = DB::table('products as p')
            ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
            ->where('p.barcode', 'LIKE', "%{$searchTerm}%")
            ->orWhere('p.name', 'LIKE', "%{$searchTerm}%")
            ->select('p.*', 'pw.counter')
            ->limit(10)
            ->get();
        
        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }
    
    // Exact barcode search (original functionality)
    $product = DB::table('products as p')
        ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
        ->where('p.barcode', $barcode)
        ->select('p.*', 'pw.counter')
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


public function index()
{
    $products = DB::table('products')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return view('items.items-edit', compact('products'));
}

public function getProductsList(Request $request)
{
    $query = DB::table('products as p')->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')->select('p.id','p.barcode','p.name','p.selling_price','p.purchase_price','p.company','p.image_producte_path','pw.counter');


    // Filter by barcode
    if ($request->filled('barcode')) {
        $query->where('p.barcode', 'like', '%' . $request->barcode . '%');
    }

    // Filter by name
    if ($request->filled('name')) {
        $query->where('p.name', 'like', '%' . $request->name . '%');
    }

    // Filter by company
    if ($request->filled('company')) {
        $query->where('p.company', 'like', '%' . $request->company . '%');
    }

    // Order by latest
    $query->orderBy('p.created_at', 'desc');

    // Paginate
    $products = $query->paginate(15);

    return response()->json([
        'success' => true,
        'products' => $products
    ]);
}



    // ... other methods ...

    /**
     * Auto-complete search for products
     */
    public function autocomplete(Request $request)
    {
        try {
            $type = $request->input('type');
            $query = $request->input('query');
            
            // Validate input
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
                    ->select('name', 'barcode', 'company')
                    ->limit(10)
                    ->get();
                    
            } elseif ($type == 'company') {
                $results = DB::table('products')
                    ->where('company', 'LIKE', $searchTerm)
                    ->select('company')
                    ->distinct()
                    ->limit(10)
                    ->get();
                    
                // Add count for each company
                foreach ($results as $result) {
                    $result->count = DB::table('products')
                        ->where('company', $result->company)
                        ->count();
                }
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
            // Log the error for debugging
            Log::error('Autocomplete error: ' . $e->getMessage());
            Log::error('Line: ' . $e->getLine());
            Log::error('File: ' . $e->getFile());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }







    public function update(Request $request)
    {
        // دۆزینەوەی کاڵا
        $product = DB::table('products')->where('id', $request->id)->first();




        // Validation تەنها بۆ new_barcode
        $request->validate(
            [
                'new_barcode' => 'required|string'
            ],
            [
                'new_barcode.required' => 'تکایە بارکۆد بنووسە ',
        
            ]
        );

        // بەهای وێنەکان لەسەر بنەمای دۆخی هەنووکەیی
        $imageName = $product->image_product_camera; // بەکارهێنانی وێنەی کۆن بە شێوازی پێشگریمان
        $imagePath = $product->image_producte_path; // بەکارهێنانی وێنەی کۆن بە شێوازی پێشگریمان

        // 1️⃣ Upload نوێ
        if ($request->hasFile('image_product_camera') && $request->file('image_product_camera')->isValid()) {
            // سڕینەوەی وێنەی کۆن ئەگەر هەبوو
            if ($product->image_producte_path && file_exists(public_path($product->image_producte_path))) {
                unlink(public_path($product->image_producte_path));
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image_product_camera->extension();
            $imagePath = 'images/products/' . $imageName;
            $request->image_product_camera->move(public_path('images/products'), $imageName);

        // 2️⃣ Captured image from camera
        } elseif ($request->filled('captured_image') && $request->image_source_type == 'camera') {
            // سڕینەوەی وێنەی کۆن ئەگەر هەبوو
            if ($product->image_producte_path && file_exists(public_path($product->image_producte_path))) {
                unlink(public_path($product->image_producte_path));
            }

            $imageName = time() . '_' . uniqid() . '.jpg';
            $imagePath = 'images/products/' . $imageName;

            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $request->captured_image);
            $imageData = str_replace(' ', '+', $imageData);
            file_put_contents(public_path($imagePath), base64_decode($imageData));

        // 3️⃣ Remove image (ئەگەر بەکارهێنەر ویستی وێنەکە بسڕێتەوە)
        } elseif ($request->has('remove_image') && $request->remove_image == 'true') {
            // سڕینەوەی وێنەی کۆن ئەگەر هەبوو
            if ($product->image_producte_path && file_exists(public_path($product->image_producte_path))) {
                unlink(public_path($product->image_producte_path));
            }
            $imageName = null;
            $imagePath = null;

        // 4️⃣ هیچ گۆڕانکاریەک لەسەر وێنە نەکراوە - وێنەکە وەک خۆی دەهێڵینەوە
        } else {
            // وێنەکە وەک خۆی دەهێڵینەوە - هیچ کارێک ناکەین
            // چونکە $imageName و $imagePath لە سەرەتادا بە وێنەی کۆن دیاری کراون
        }

        // Update DB
        DB::table('products')->where('id', $product->id)->update([
            'barcode' => $request->new_barcode,
            'name' => $request->name ?? $product->name,
            'company' => $request->company ?? $product->company,
            'purchase_price' => $request->purchase_price ?? $product->purchase_price,
            'selling_price' => $request->selling_price ?? $product->selling_price,
            'minimum_wearhouse' => $request->minimum_wearhouse ?? $product->minimum_wearhouse,
            'image_product_camera' => $imageName,
            'image_producte_path' => $imagePath,
            'updated_at' => now(),
        ]);

   
                // نوێکردنەوەی ئەو تۆمارەی کە هەیە
                DB::table('product_wearhouse')
                    ->where('id_product', $product->id)
                    ->update([
                        'counter' => $request->minimum_wearhouse,
                    ]);
            
        

        $updatedProduct = DB::table('products')->where('id', $product->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'کاڵا بە سەرکەوتوویی نوێ کرایەوە',
            'product' => $updatedProduct,
          
        ]);
    }



public function destroy(Request $request, $id)
{
    try {

        // find product
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'کاڵا نەدۆزرایەوە!'
            ], 404);
        }

        // delete image
        if (!empty($product->image_producte_path)) {
            $filePath = public_path($product->image_producte_path);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // delete product
        DB::table('products')->where('id', $id)->delete();
        DB::table('product_wearhouse')->where('id_product', $id)->delete();

        

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


 public function searchByName(Request $request)
    {
        try {
            $searchTerm = $request->input('name');

            // Validate search term
            if (empty($searchTerm) || strlen(trim($searchTerm)) < 2) {
                return response()->json([
                    'success' => true,
                    'products' => []
                ]);
            }

            $searchTerm = trim($searchTerm);
            $searchParam = "%{$searchTerm}%";

            // Query products with their warehouse stock
            $products = DB::table('products as p')
                ->select(
                    'p.id',
                    'p.name',
                    'p.company',
                    'p.barcode',
                    'p.image_product_camera',
                    'p.image_producte_path',
                    'p.purchase_price',
                    'p.selling_price',
                    'p.minimum_wearhouse',
                    'pw.counter'
                )
                ->leftJoin('product_wearhouse as pw', 'pw.id_product', '=', 'p.id')
                ->where(function($query) use ($searchParam) {
                    $query->where('p.name', 'LIKE', $searchParam)
                          ->orWhere('p.company', 'LIKE', $searchParam);
                })
                ->orderBy('p.name')
                ->limit(10)
                ->get();

            // Format the response
            $productsArray = $products->map(function($product) {
                return [
                    'id' => $product->id ?? null,
                    'name' => $product->name ?? '',
                    'company' => $product->company ?? '',
                    'barcode' => $product->barcode ?? '',
                    'image_product_camera' => $product->image_product_camera ?? '',
                    'image_producte_path' => $product->image_producte_path ?? '',
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
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'هەڵەی ناوەخۆیی سێرڤەر',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function getProductByBarcode(Request $request)
{
    $request->validate([
        'barcode' => 'required|string'
    ]);

    // Get ALL products with this barcode (not just first)
    $products = DB::table('products')
                ->where('barcode', $request->barcode)
                ->get();

    if ($products->isEmpty()) {
        return response()->json([
            'exists' => false,
            'message' => 'بارکۆد نەدۆزرایەوە'
        ]);
    }

    // Get warehouse data for all products
    $productIds = $products->pluck('id')->toArray();
    $warehouses = DB::table('product_wearhouse')
                   ->whereIn('id_product', $productIds)
                   ->get()
                   ->keyBy('id_product');

    $productsList = [];
    foreach ($products as $product) {
        $warehouse = $warehouses->get($product->id);
        $productsList[] = [
            'id' => $product->id,
            'name' => $product->name,
            'barcode' => $product->barcode,
            'company' => $product->company,
            'purchase_price' => $product->purchase_price,
            'selling_price' => $product->selling_price,
            'minimum_wearhouse' => $product->minimum_wearhouse,
            'image_producte_path' => $product->image_producte_path,
            'warehouse_counter' => $warehouse->counter ?? 0,
            'has_stock' => ($warehouse->counter ?? 0) > 0
        ];
    }

    return response()->json([
        'exists' => true,
        'products' => $productsList,
        'total_count' => count($productsList)
    ]);
}




}
