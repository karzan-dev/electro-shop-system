<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CasherController extends Controller
{





    /**
     * Get cashier details with daily summary
     */
    public function getDetails($id)
    {
        try {
            // Get cashier info
            $cashier = DB::table('users')
                ->where('id', $id)
                ->where('role', 'Casher')
                ->select('id', 'name')
                ->first();

            if (!$cashier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cashier not found'
                ], 404);
            }

            // Get today's sales summary
            $today = now()->format('Y-m-d');
            
            $todaySales = DB::table('sales')
                ->where('user_id', $id)
                ->whereDate('created_at', $today)
                ->select(
                    DB::raw('COUNT(*) as invoice_count'),
                    DB::raw('COALESCE(SUM(total), 0) as total_sales'),
                    DB::raw('COALESCE(SUM(discount), 0) as total_discount')
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

            return response()->json([
                'success' => true,
                'name' => $cashier->name,
                'today_sales' => $todaySales->total_sales ?? 0,
                'today_discount' => $todaySales->total_discount ?? 0,
                'invoice_count' => $todaySales->invoice_count ?? 0,
                'total_returns' => $todayReturns->total_returns ?? 0,
                'return_count' => $todayReturns->return_count ?? 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading cashier details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * وەرگرتنی هەموو کاشێرەکان
     */
    public function index()
    {
        $cashers = DB::table('users')
            ->select('id', 'name', 'email', 'created_at')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cashers
        ]);
    }

    /**
     * وەرگرتنی داتای کاشێر بە ID
     */
  public function getData(Request $request)
{
    $users = DB::table('users')->get();

    return response()->json([
        'success' => true,
        'users' => $users
    ]);
}

    /**
     * نمایش فۆڕمی پێدانی وردە
     */
    public function create()
    {
        // هەموو کاشێرەکان وەربگرە بۆ لیستەکە
        $cashers = DB::table('users')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return view('casher.coin.create', compact('cashers'));
    }

    /**
     * تۆمارکردنی وردە بۆ کاشێر
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'casher_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1|max:10000000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // تۆمارکردنی وردە لە تەیبڵی casher_coin
            $coinId = DB::table('casher_coin')->insertGetId([
                'casher_id' => $request->casher_id,
                'amount' => $request->amount,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // وەرگرتنی کۆی گشتی نوێ
            $totalAmount = DB::table('casher_coin')
                ->where('casher_id', $request->casher_id)
                ->sum('amount');

            return response()->json([
                'success' => true,
                'message' => 'وردەکە بە سەرکەوتوویی تۆمارکرا',
                'coin_id' => $coinId,
                'total_amount' => (float) $totalAmount,
                'last_amount' => (float) $request->amount,
                'last_date' => now()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا لە کاتی تۆمارکردن: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * مێژووی وردەکانی کاشێر
     */
    public function history($id)
    {
        $casher = DB::table('users')->where('id', $id)->first();

        if (!$casher) {
            return response()->json([
                'success' => false,
                'message' => 'کاشێر نەدۆزرایەوە'
            ], 404);
        }

        $coins = DB::table('casher_coin')
            ->where('casher_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalAmount = DB::table('casher_coin')
            ->where('casher_id', $id)
            ->sum('amount');

        return response()->json([
            'success' => true,
            'casher' => [
                'id' => $casher->id,
                'name' => $casher->name,
                'email' => $casher->email
            ],
            'total_amount' => (float) $totalAmount,
            'coins' => $coins
        ]);
    }

    /**
     * وەرگرتنی کاشێرێک بە ناو
     */
    public function searchByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $cashers = DB::table('users')
            ->select('id', 'name', 'email')
            ->where('name', 'LIKE', '%' . $request->name . '%')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cashers
        ]);
    }
}
