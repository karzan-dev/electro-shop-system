<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockProductController extends Controller
{
    public function reportStock(Request $request)
    {
        try {
            $query = DB::table('stock_item')
                ->join('products', 'stock_item.products_id', '=', 'products.id')
                ->leftJoin('users', 'stock_item.user_id', '=', 'users.id')
                ->select(
                    'stock_item.id',
                    'stock_item.Amount as amount',
                    'stock_item.Stock_Couse as stock_reason',
                    'stock_item.Note as notes',
                    'stock_item.Entry_Date as entry_date',
                    'stock_item.user_id',
                    'users.name as user_name',
                    'products.id as product_id',
                    'products.name as product_name',
                    'products.barcode',
                    'products.purchase_price',
                );

            // Date filters
            if ($request->filled('date_from')) {
                $query->whereDate('stock_item.Entry_Date', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('stock_item.Entry_Date', '<=', $request->date_to);
            }

            // Barcode filter
            if ($request->filled('barcode')) {
                $barcode = trim($request->barcode);
                $query->where('products.barcode', 'like', '%' . $barcode . '%');
            }

            // Statistics - Create a separate query without orderBy
            $statsQuery = DB::table('stock_item')
                ->join('products', 'stock_item.products_id', '=', 'products.id');
            
            // Apply the same filters to stats query
            if ($request->filled('date_from')) {
                $statsQuery->whereDate('stock_item.Entry_Date', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $statsQuery->whereDate('stock_item.Entry_Date', '<=', $request->date_to);
            }
            if ($request->filled('barcode')) {
                $barcode = trim($request->barcode);
                $statsQuery->where('products.barcode', 'like', '%' . $barcode . '%');
            }
            
            $stats = $statsQuery->select(
                DB::raw('COUNT(DISTINCT stock_item.id) as total'),
                DB::raw('COALESCE(SUM(stock_item.Amount), 0) as total_quantity'),
                DB::raw('COALESCE(SUM(stock_item.Amount * products.purchase_price), 0) as total_cost'),
                DB::raw('COUNT(DISTINCT stock_item.Stock_Couse) as unique_reasons')
            )->first();

            // Add orderBy for main query
            $query->orderBy('stock_item.Entry_Date', 'desc');

            // Pagination
            $perPage = $request->input('per_page', 15);
            $items = $query->paginate($perPage);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $items->items(),
                    'total' => (int)($stats->total ?? 0),
                    'total_quantity' => (int)($stats->total_quantity ?? 0),
                    'total_cost' => (float)($stats->total_cost ?? 0),
                    'unique_reasons' => (int)($stats->unique_reasons ?? 0),
                    'current_page' => $items->currentPage(),
                    'last_page' => $items->lastPage(),
                    'from' => $items->firstItem(),
                    'to' => $items->lastItem(),
                    'total_items' => $items->total(),
                ]);
            }

            return view('stock-products.report', compact('items', 'stats'));
            
        } catch (\Exception $e) {
            Log::error('Stock Report Error: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'هەڵەیەک ڕوویدا');
        }
    }
}