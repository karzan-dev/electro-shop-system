<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class brandController extends Controller
{
    /**
     * 📋 لیستی کۆمپانیاکان بۆ خشتە
     * GET /brands/list
     */
    public function listb(Request $request)
    {
        try {
            $perPage = (int) $request->get('per_page', 15);
            $perPage = max(1, min($perPage, 100));
            $search  = trim($request->get('search', ''));
            $page    = (int) $request->get('page', 1);

            $query = DB::table('companies')
                ->select('id', 'company_name as name')
                ->whereNotNull('company_name')
                ->where('company_name', '!=', '');

            if ($search !== '') {
                $query->where('company_name', 'LIKE', '%' . $search . '%');
            }

            $total    = $query->count();
            $lastPage = max(1, (int) ceil($total / $perPage));
            $page     = max(1, min($page, $lastPage));

            $companies = $query
                ->orderBy('company_name', 'asc')
                ->offset(($page - 1) * $perPage)
                ->limit($perPage)
                ->get();

            // 🔢 ژمارەی کاڵاکان بۆ هەر کۆمپانیایەک
            $companies = $companies->map(function ($company) {
                $company->products_count = DB::table('products')
                    ->where('company_id', $company->id)
                    ->count();
                return $company;
            });

            return response()->json([
                'success'      => true,
                'brands'       => $companies,
                'current_page' => $page,
                'last_page'    => $lastPage,
                'per_page'     => $perPage,
                'total'        => $total,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
                'brands'  => [],
            ], 500);
        }
    }

    /**
     * 🔎 گەڕانی خێرا — بۆ Autocomplete
     * GET /brands/search?q=...
     */
    public function searchb(Request $request)
    {
        try {
            $q     = trim($request->get('q', ''));
            $limit = (int) $request->get('limit', 20);
            $limit = max(1, min($limit, 100));

            $query = DB::table('companies')
                ->select('id', 'company_name as company')
                ->whereNotNull('company_name')
                ->where('company_name', '!=', '');

            if ($q !== '') {
                $query->where('company_name', 'LIKE', '%' . $q . '%')
                      ->orderByRaw("
                          CASE 
                              WHEN company_name LIKE ? THEN 1
                              WHEN company_name LIKE ? THEN 2
                              ELSE 3
                          END ASC
                      ", [$q . '%', '%' . $q . '%']);
            }

            $companies = $query
                ->orderBy('company_name', 'asc')
                ->limit($limit)
                ->get();

            return response()->json([
                'success'   => true,
                'companies' => $companies,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => 'هەڵە: ' . $e->getMessage(),
                'companies' => [],
            ], 500);
        }
    }

    /**
     * 💾 زیادکردنی کۆمپانیای نوێ
     * POST /brands/store
     */
    public function storeb(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'تکایە ناوی براند بنووسە',
        ]);

        try {
            $name = trim($request->name);

            if ($name === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'ناوی براند نابێت بەتاڵ بێت',
                ], 422);
            }

            $exists = DB::table('companies')
                ->whereRaw('LOWER(company_name) = ?', [mb_strtolower($name)])
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'ئەم براندە پێشتر تۆمارکراوە',
                ], 422);
            }

            $id = DB::table('companies')->insertGetId([
                'company_name' => $name,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'براند بە سەرکەوتوویی زیادکرا',
                'brand'   => [
                    'id'   => $id,
                    'name' => $name,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ✏️ نوێکردنەوەی ناوی کۆمپانیا
     * POST /brands/update
     */
    public function updateb(Request $request)
    {
        $request->validate([
            'id'   => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'تکایە ناوی براند بنووسە',
        ]);

        try {
            $name = trim($request->name);

            if ($name === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'ناوی براند نابێت بەتاڵ بێت',
                ], 422);
            }

            $exists = DB::table('companies')
                ->whereRaw('LOWER(company_name) = ?', [mb_strtolower($name)])
                ->where('id', '!=', $request->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'ئەم ناوە بۆ براندێکی تر بەکارهاتووە',
                ], 422);
            }

            DB::table('companies')
                ->where('id', $request->id)
                ->update([
                    'company_name' => $name,
                    'updated_at'   => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'ناوی براند بە سەرکەوتوویی نوێکرایەوە',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 🗑️ سڕینەوەی کۆمپانیا
     * DELETE /brands/{id}/delete
     */
    public function destroyb($id)
    {
        try {
            $company = DB::table('companies')->where('id', $id)->first();

            if (!$company) {
                return response()->json([
                    'success' => false,
                    'message' => 'براند نەدۆزرایەوە',
                ], 404);
            }

            // 🔍 پشکنینی کاڵاکان بە company_id
            $productsCount = DB::table('products')
                ->where('company_id', $id)
                ->count();

            if ($productsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "ناتوانرێت بسڕدرێتەوە — ئەم براندە بە {$productsCount} کاڵاوە بەستراوەتەوە",
                ], 422);
            }

            DB::table('companies')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'براند بە سەرکەوتوویی سڕایەوە',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage(),
            ], 500);
        }
    }
}