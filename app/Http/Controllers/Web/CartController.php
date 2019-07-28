<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class CartController extends Controller
{
    public function __construct()
    {
        $this->setRedirectPath('/cart');
    }

    public function index(Request $request)
    {
        $title = __('web.cart');

        $breadcrumbs[] = [
            'url'  => route('cart'),
            'name' => $title,
        ];

        return view('web.cart', [
            'pageTitle'   => $title,
            'breadcrumbs' => $breadcrumbs,
            'items'       => Cart::getItems(),
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $product = Product::find($request->product_id);
        if (!$product || $product->hidden) {
            return $this->error(__('cart.out_of_stock'));
        }

        $item = Cart::updateOrCreate(
            [
                'raw_id'     => Cart::rawID(),
                'product_id' => $request->product_id,
                'user_id'    => Auth::guest() ? 0 : Auth::user()->id,
            ],
            ['quantity' => $request->quantity]
        );

        if ($request->checkout) {
            return redirect(route('checkout'));
        } else {
            return redirect(route('cart'));
        }
    }

    public function remove(Request $request)
    {
        Cart::getQuery()->where('product_id', $request->product_id)->delete();
        return $this->success('');
    }

    public function refresh()
    {
        return $this->success('OK', Cart::lastest());
    }
}
