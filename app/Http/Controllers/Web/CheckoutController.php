<?php

namespace App\Http\Controllers\Web;

use App\Models\Address;
use App\Models\Order;
use Auth;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->setRedirectPath('/checkout');
    }

    public function index(Request $request)
    {
        if (Auth::guest()) {
            return redirect(route('quickpay'));
        }

        if (Cart::countItems() == 0) {
            return back();
        }

        $title = __('web.checkout');

        $breadcrumbs = [
            [
                'url'  => route('cart'),
                'name' => __('web.cart'),
            ],
            [
                'url'  => route('checkout'),
                'name' => $title,
            ],
        ];

        $addressbook = Address::where('user_id', Auth::user()->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('id', 'asc')
            ->get();

        $addressID = session('address_id');
        if (!$addressID) {
            foreach ($addressbook as $address) {
                if ($address->is_default) {
                    $addressID = $address->id;
                    break;
                }
            }
        }

        $order = null;
        $orderID = session('order_id', $request->input('order_id', 0));
        if (session('step') == 5 || $orderID) {
            $order = Order::find($orderID);
            if (!$order) {
                app('session')->forget(['step', 'order_id', 'address_id']);
                return redirect('/fail')->withErrors(__('web.invalid_order'));
            }
            if (in_array($order->status, ['expired', 'canceled'])) {
                return redirect(route('checkout.fail'));
            } elseif ($order->status != 'pending') {
                return redirect(route('checkout.done'));
            }
            session(['step' => 5, 'order_id' => $order->id]); // the order has been created
        }

        return view('web.checkout', [
            'pageTitle'   => $title,
            'breadcrumbs' => $breadcrumbs,
            'addressbook' => $addressbook,
            'addressID'   => $addressID,
            'orderID'     => $orderID,
            'order'       => $order,
            'step'        => session('step', 1),
            'total'       => Cart::totalMoney(),
        ]);
    }

    public function step1(Request $request)
    {
        if ($request->address_option == 'existing') {
            if (!$request->address_id) {
                return $this->error('Invalid address');
            }
            $address = Address::where('id', $request->address_id)
                ->where('user_id', Auth::user()->id)
                ->first();
            if (!$address) {
                return $this->error(__('web.invalid_address'));
            }
            session(['address_id' => $address->id]);
        } else {
            $address = new Address;
            $address->user_id = Auth::user()->id;
            $address->set($request->all());

            session(['address_id' => $address->id]);
        }
        session(['step' => 2]);
        return $this->success('');
    }

    public function step2()
    {
        session(['step' => 3]);
        return $this->success('');
    }

    public function step3()
    {
        session(['step' => 4]);
        return $this->success('');
    }

    public function confirm(Request $request)
    {
        // we only create order when it does not exist
        if (!session('order_id')) {
            try {
                // place the order
                $order = new Order;
                $order->ip = $request->ip();
                $order->user_agent = $request->userAgent();
                $order->user_id = Auth::user()->id;
                $order->email = Auth::user()->email;
                $order->setData($request->all());

                $addressID = session('address_id');
                if (!$addressID) {
                    throw ValidationException::withMessages(['address' => __('web.invalid_shipping_address')]);
                }

                $address = Address::where('id', $addressID)->first();
                if (!$address) {
                    throw ValidationException::withMessages(['address' => __('web.invalid_shipping_address')]);
                }

                $order->setAddress($address->toArray());
                $order->confirmed_at = date('Y-m-d H:i:s');
                $order->save();

                $items = Cart::getItems();
                foreach ($items as $item) {
                    $order->addProduct($item->product, $item->quantity);
                }

                $order->calculate();
            } catch (ValidationException $e) {
                return redirect('/fail')->withErrors($e->errors());
            }
        } else {
            $order = Order::find(session('order_id'));
        }

        session(['step' => 5, 'order_id' => $order->id]);
        return redirect(route('checkout'));
    }

    public function done()
    {
        $title = __('order.placed');

        $breadcrumbs = [
            [
                'url'  => route('cart'),
                'name' => __('web.cart'),
            ],
            [
                'url'  => route('checkout'),
                'name' => __('web.checkout'),
            ],
            [
                'url'  => route('checkout.done'),
                'name' => __('web.success'),
            ],
        ];

        // clear session
        app('session')->forget(['step', 'order_id', 'address_id']);

        return view('web.checkout.done', [
            'pageTitle'   => $title,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function fail()
    {
        $order = Order::find(session('order_id'));
        if (!$order) {
            return redirect(route('account'));
        }

        $title = __('order.order') . __('order.' . $order->status);

        $breadcrumbs = [
            [
                'url'  => route('cart'),
                'name' => __('web.cart'),
            ],
            [
                'url'  => route('checkout'),
                'name' => __('web.checkout'),
            ],
            [
                'url'  => route('checkout.fail'),
                'name' => $title,
            ],
        ];

        // clear session
        app('session')->forget(['step', 'order_id', 'address_id']);

        return view('web.checkout.fail', [
            'pageTitle'   => $title,
            'breadcrumbs' => $breadcrumbs,
            'status'      => __('order.' . $order->status),
        ]);
    }
}
