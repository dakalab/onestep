<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use Auth;
use Cart;
use Illuminate\Http\Request;

class QuickPayController extends Controller
{
    public function __construct()
    {
        $this->setRedirectPath('/checkout');
    }

    public function index(Request $request)
    {
        $title = __('web.checkout');

        if (!Auth::guest()) {
            return redirect(route('checkout'));
        }

        $breadcrumbs = [
            [
                'url'  => route('cart'),
                'name' => __('web.cart'),
            ],
            [
                'url'  => route('quickpay'),
                'name' => $title,
            ],
        ];

        // create a temp order(confirmed_at is null)
        $order = new Order;
        $order->ip = $request->ip();
        $order->user_agent = $request->userAgent();
        $order->user_id = 0;
        $order->setData();
        $order->setEmptyAddress();
        $order->save();

        $items = Cart::getItems();
        foreach ($items as $item) {
            $order->addProduct($item->product, $item->quantity);
        }

        $order->calculate();

        return view('web.quickpay', [
            'pageTitle'   => $title,
            'breadcrumbs' => $breadcrumbs,
            'total'       => Cart::totalMoney(),
            'order'       => $order,
        ]);
    }
}
