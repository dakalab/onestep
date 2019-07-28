<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\User;
use DB;
use Helper;

class IndexController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');

        $newOrder = (int) Order::whereNotNull('confirmed_at')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', '<>', 'canceled')
            ->count();

        $income = Order::whereNotNull('confirmed_at')
            ->whereIn('status', ['paid', 'shipped', 'complete'])
            ->whereBetween('created_at', [$start, $end])
            ->sum(DB::raw('`total` * `exchange_rate`'));

        $newUser = (int) User::whereBetween('created_at', [$start, $end])->count();
        $totalUser = (int) User::count();

        $dailySales = [];
        $num = 10;
        $from = strtotime(date('Y-m-d')) - 86400 * 9;
        for ($i = 0; $i < 10; $i++) {
            $t = $from + $i * 86400;

            $v = Order::whereNotNull('confirmed_at')
                ->whereIn('status', ['paid', 'shipped', 'complete'])
                ->whereBetween('created_at', [
                    date('Y-m-d 00:00:00', $t), date('Y-m-d 23:59:59', $t),
                ])
                ->sum(DB::raw('`total` * `exchange_rate`'));

            $dailySales[date('Y-m-d', $t)] = round($v, 2);
        }

        $months = [];
        $monthlySales = [];
        $start = mktime(0, 0, 0, date('n'), 1, date('Y') - 1);
        for ($i = 0; $i <= 12; $i++) {
            $t = Helper::periodicTime($start, $i);
            $months[] = date('Y-m', $t);

            $v = Order::whereNotNull('confirmed_at')
                ->whereIn('status', ['paid', 'shipped', 'complete'])
                ->whereBetween('created_at', [
                    date('Y-m-d 00:00:00', $t), date('Y-m-t 23:59:59', $t),
                ])
                ->sum(DB::raw('`total` * `exchange_rate`'));
            $monthlySales[] = round($v, 2);
        }

        return view('admin.index', [
            'pageTitle'    => 'Dashboard',
            'newOrder'     => $newOrder,
            'income'       => Helper::money($income),
            'newUser'      => $newUser,
            'totalUser'    => $totalUser,
            'dailySales'   => $dailySales,
            'months'       => $months,
            'monthlySales' => $monthlySales,
        ]);
    }
}
