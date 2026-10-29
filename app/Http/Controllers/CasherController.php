<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CasherController extends Controller
{
    /**
     * نمایش فۆڕم + لیستی هەموو وردەکان
     */
    public function create()
    {
        $cashers = DB::table('users')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        $allCoins = DB::table('casher_coin')
            ->leftJoin('users', 'casher_coin.casher_id', '=', 'users.id')
            ->select(
                'casher_coin.id',
                'casher_coin.casher_id',
                'casher_coin.amount',
                'casher_coin.created_at',
                'users.name as casher_name',
                'users.email as casher_email'
            )
            ->orderBy('casher_coin.created_at', 'desc')
            ->get();

        $totalAll = DB::table('casher_coin')->sum('amount');

        $casherStats = DB::table('casher_coin')
            ->join('users', 'casher_coin.casher_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(casher_coin.id) as total_transactions'),
                DB::raw('SUM(casher_coin.amount) as total_amount'),
                DB::raw('MAX(casher_coin.created_at) as last_transaction')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_amount', 'desc')
            ->get();

        return view('items.casher-coin', compact(
            'cashers',
            'allCoins',
            'totalAll',
            'casherStats'
        ));
    }

    /**
     * گۆڕینی کات بۆ کوردی — "berî 1 saet"
     */
    private function humanTimeKu($date)
    {
        if (!$date) return '-';

        $carbon = Carbon::parse($date);
        $diff   = $carbon->diffInSeconds(now());
        $isPast = $carbon->lessThan(now());

        if ($diff < 30) {
            return 'ئێستا';
        }

        $prefix = $isPast ? 'berî' : 'piştî';

        if ($diff < 60) {
            return $prefix . ' ' . $diff . ' چرکە';
        }

        $minutes = floor($diff / 60);
        if ($minutes < 60) {
            return $prefix . ' ' . $minutes . ' خولەک';
        }

        $hours = floor($diff / 3600);
        if ($hours < 24) {
            return $prefix . ' ' . $hours . ' saet';
        }

        $days = floor($diff / 86400);
        if ($days < 30) {
            return $prefix . ' ' . $days . ' ڕۆژ';
        }

        $months = floor($days / 30);
        if ($months < 12) {
            return $prefix . ' ' . $months . ' مانگ';
        }

        $years = floor($days / 365);
        return $prefix . ' ' . $years . ' ساڵ';
    }

    /**
     * وەرگرتنی داتای کاشێرەکان (AJAX) — dropdown
     */
    public function getData(Request $request)
    {
        $users = DB::table('users')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                $totalCoins = DB::table('casher_coin')
                    ->where('casher_id', $user->id)
                    ->sum('amount');

                $lastCoin = DB::table('casher_coin')
                    ->where('casher_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $count = DB::table('casher_coin')
                    ->where('casher_id', $user->id)
                    ->count();

                return [
                    'id'          => $user->id,
                    'name'        => $user->name,
                    'email'       => $user->email,
                    'total_coins' => number_format((float) ($totalCoins ?? 0)) . ' دینار',
                    'last_coin'   => $lastCoin
                        ? $this->humanTimeKu($lastCoin->created_at)
                        : '-',
                    'count'       => $count,
                ];
            });

        return response()->json([
            'success' => true,
            'users'   => $users
        ]);
    }

    /**
     * وەرگرتنی زانیاری کاشێر بە ID (AJAX) — info panel
     */
    public function getCasherDetails($id)
    {
        $casher = DB::table('users')->where('id', $id)->first();

        if (!$casher) {
            return response()->json([
                'success' => false,
                'message' => 'کاشێر نەدۆزرایەوە'
            ], 404);
        }

        $totalCoins = DB::table('casher_coin')
            ->where('casher_id', $id)
            ->sum('amount');

        $lastCoin = DB::table('casher_coin')
            ->where('casher_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        $count = DB::table('casher_coin')
            ->where('casher_id', $id)
            ->count();

        return response()->json([
            'success' => true,
            'casher'  => [
                'id'          => $casher->id,
                'name'        => $casher->name,
                'email'       => $casher->email,
                'total_coins' => number_format((float) ($totalCoins ?? 0)) . ' دینار',
                'last_coin'   => $lastCoin
                    ? $this->humanTimeKu($lastCoin->created_at)
                    : '-',
                'count'       => $count,
            ]
        ]);
    }

    /**
     * تۆمارکردنی وردە
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'casher_id' => 'required|exists:users,id',
            'amount'    => 'required|integer|min:1|max:10000000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $coinId = DB::table('casher_coin')->insertGetId([
                'casher_id'  => $request->casher_id,
                'amount'     => $request->amount,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $totalAmount = DB::table('casher_coin')
                ->where('casher_id', $request->casher_id)
                ->sum('amount');

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'وردەکە بە سەرکەوتوویی تۆمارکرا',
                'coin_id'      => $coinId,
                'total_amount' => (float) $totalAmount,
                'last_amount'  => (float) $request->amount,
                'last_date'    => now()->format('Y-m-d H:i')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'هەڵەیەک ڕوویدا: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * نوێکردنەوەی وردە (دەستکاریکردن)
     */
    public function update(Request $request, $id)
    {
        $coin = DB::table('casher_coin')->where('id', $id)->first();

        if (!$coin) {
            return response()->json([
                'success' => false,
                'message' => 'وردە نەدۆزرایەوە'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:1|max:10000000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            DB::table('casher_coin')->where('id', $id)->update([
                'amount'     => $request->amount,
                'updated_at' => now(),
            ]);

            $totalAmount = DB::table('casher_coin')
                ->where('casher_id', $coin->casher_id)
                ->sum('amount');

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'وردەکە بە سەرکەوتوویی نوێکرایەوە',
                'coin_id'      => (int) $id,
                'amount'       => (int) $request->amount,
                'total_amount' => (float) $totalAmount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * هەموو مێژووی وردەکان (AJAX)
     */
    public function allHistory(Request $request)
    {
        $query = DB::table('casher_coin')
            ->leftJoin('users', 'casher_coin.casher_id', '=', 'users.id')
            ->select(
                'casher_coin.id',
                'casher_coin.casher_id',
                'casher_coin.amount',
                'casher_coin.created_at',
                'users.name as casher_name',
                'users.email as casher_email'
            );

        if ($request->filled('casher_id')) {
            $query->where('casher_coin.casher_id', $request->casher_id);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('casher_coin.created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('casher_coin.created_at', '<=', $request->to_date);
        }

        $coins = $query->orderBy('casher_coin.created_at', 'desc')->get();

        return response()->json([
            'success'      => true,
            'total_amount' => (float) $coins->sum('amount'),
            'count'        => $coins->count(),
            'data'         => $coins
        ]);
    }

    /**
     * سڕینەوەی وردە
     */
    public function destroy($id)
    {
        $coin = DB::table('casher_coin')->where('id', $id)->first();

        if (!$coin) {
            return response()->json([
                'success' => false,
                'message' => 'وردە نەدۆزرایەوە'
            ], 404);
        }

        try {
            DB::table('casher_coin')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'وردەکە سڕایەوە'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'هەڵە: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * مێژووی وردەکانی کاشێر (AJAX)
     */
    public function history($id)
    {
        $coins = DB::table('casher_coin')
            ->where('casher_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'coins'   => $coins
        ]);
    }

    /**
     * گەڕان بە ناو
     */
    public function searchByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
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
            'data'    => $cashers
        ]);
    }
}