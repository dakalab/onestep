<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use Helper;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $title = __('order.tracking');

        $breadcrumbs[] = [
            'url'  => route('tracking'),
            'name' => $title,
        ];

        $number = $request->number;
        $express = '';

        $order = Order::where('order_no', $number)
            ->orWhere('tracking_no', $number)->first();
        if ($order) {
            $number = $order->tracking_no;
            $express = $order->express;
        }

        return view('web.tracking', [
            'pageTitle'   => $title,
            'breadcrumbs' => $breadcrumbs,
            'number'      => $number,
            'result'      => Helper::track($number, $express),
        ]);
    }
}
