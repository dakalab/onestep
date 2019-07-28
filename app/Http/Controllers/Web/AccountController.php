<?php

namespace App\Http\Controllers\Web;

use App\Models\Address;
use App\Models\Order;
use App\Models\Wishlist;
use App\User;
use Auth;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class AccountController extends Controller
{
    public $breadcrumbs = [];

    public function __construct()
    {
        $this->breadcrumbs[] = [
            'url'  => route('account'),
            'name' => __('account.my_account'),
        ];
    }

    public function index()
    {
        return view('web.account.index', [
            'pageTitle'   => __('account.my_account'),
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function edit(Request $request)
    {
        $title = __('account.info');

        $this->breadcrumbs[] = [
            'url'  => route('account.edit'),
            'name' => $title,
        ];

        $user = Auth::user();

        if ($request->isMethod('post')) {
            $data['name'] = $request->input('name');
            $rules['name'] = 'required|max:255|min:2';

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $user->name = $data['name'];
            $user->save();

            return $this->success(__('web.updated'));
        }

        return view('web.account.edit', [
            'pageTitle'   => $title,
            'user'        => $user,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function password(Request $request)
    {
        $title = __('account.change_password');

        $this->breadcrumbs[] = [
            'url'  => route('account.password'),
            'name' => $title,
        ];

        $user = Auth::user();

        if ($request->isMethod('post')) {
            $data['password'] = $request->input('password');
            $data['password_confirmation'] = $request->input('password_confirmation');
            $rules['password'] = 'required|confirmed|min:6';

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $user->password = bcrypt($data['password']);
            $user->save();

            return $this->success(__('web.updated'));
        }

        return view('web.account.password', [
            'pageTitle'   => $title,
            'user'        => $user,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function wishlist(Request $request)
    {
        $title = __('account.wishlist');

        $this->breadcrumbs[] = [
            'url'  => route('account.wishlist'),
            'name' => $title,
        ];

        $query = Wishlist::where('user_id', Auth::user()->id)->orderBy('id', 'desc');

        $data = $query->paginate(10);

        return view('web.account.wishlist', [
            'pageTitle'   => $title,
            'breadcrumbs' => $this->breadcrumbs,
            'data'        => $data,
        ]);
    }

    public function deleteWishlist(Request $request)
    {
        Wishlist::where('user_id', Auth::user()->id)
            ->where('product_id', $request->product_id)
            ->delete();
        return $this->success(__('account.deleted'));
    }

    public function address(Request $request)
    {
        $title = __('account.addressbook');

        $this->breadcrumbs[] = [
            'url'  => route('account.address'),
            'name' => $title,
        ];

        $query = Address::where('user_id', Auth::user()->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('id', 'asc');

        $data = $query->paginate(10);

        return view('web.account.address', [
            'pageTitle'   => $title,
            'breadcrumbs' => $this->breadcrumbs,
            'data'        => $data,
        ]);
    }

    public function setAddress(Request $request)
    {
        $title = __('address.new_address');

        if ($request->id) {
            $title = __('address.edit_address');
            $address = Address::find($request->id);
        }
        if (empty($address)) {
            $address = new Address;
            $address->user_id = Auth::user()->id;
            $address->country = config('app.country');
        }

        if ($request->isMethod('post')) {
            $address->set($request->all());
            return $this->success(__('web.updated'));
        }

        $this->breadcrumbs[] = [
            'url'  => route('account.address'),
            'name' => __('account.addressbook'),
        ];
        $this->breadcrumbs[] = [
            'url'  => route('account.address.set'),
            'name' => $title,
        ];

        return view('web.account.address_set', [
            'pageTitle'   => $title,
            'address'     => $address,
            'countries'   => Helper::countries(),
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function deleteAddress($id)
    {
        Address::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->delete();
        return $this->success(__('account.deleted'));
    }

    public function orders(Request $request)
    {
        $title = __('account.order_history');

        $this->breadcrumbs[] = [
            'url'  => route('account.orders'),
            'name' => $title,
        ];

        $query = Order::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc');

        $data = $query->paginate(10);

        return view('web.account.orders', [
            'pageTitle'   => $title,
            'breadcrumbs' => $this->breadcrumbs,
            'data'        => $data,
        ]);
    }

    public function cancelOrder($id)
    {
        Order::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->update(['status' => 'canceled']);
        return $this->success(__('order.order_canceled'));
    }

    public function orderDetail($id)
    {
        $title = 'Order Detail';

        $this->breadcrumbs[] = [
            'url'  => route('account.order.detail', ['id' => $id]),
            'name' => $title,
        ];

        $order = Order::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return redirect('/fail')->withErrors(__('order.invalid_order'));
        }

        return view('web.account.order_detail', [
            'pageTitle'   => $title,
            'breadcrumbs' => $this->breadcrumbs,
            'order'       => $order,
        ]);
    }
}
