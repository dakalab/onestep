<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderProduct;
use Auth;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class OrderController extends Controller
{
    public function getList(Request $request)
    {
        Order::expire();

        $title = '订单列表';
        $query = Order::whereNotNull('confirmed_at')->orderBy('id', 'desc');

        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('firstname', 'like', '%' . $request->keyword . '%')
                    ->orWhere('lastname', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', '=', $request->keyword)
                    ->orWhere('order_no', '=', $request->keyword);
            });
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->paginate(20);

        return view('admin.order.list', [
            'pageTitle'  => $title,
            'data'       => $data,
            'params'     => $request->all(),
            'statusList' => Order::$statusList,
        ]);
    }

    public function view($id)
    {
        $title = '订单详情';

        $order = Order::where('id', $id)->first();

        return view('admin.order.detail', [
            'pageTitle' => $title,
            'order'     => $order,
        ]);
    }

    public function cancel($id)
    {
        Order::where('id', $id)->update(['status' => 'canceled']);
        return $this->success('Order canceled!');
    }

    public function edit($id, Request $request)
    {
        $title = '订单编辑';

        $order = Order::find($id);

        if (!$order) {
            return $this->error('无效订单');
        }

        if ($request->isMethod('post')) {
            $rules = [
                'firstname' => 'required',
                'lastname'  => 'required',
                'address'   => 'required|min:10',
                'country'   => 'required',
                'city'      => 'required',
                'postcode'  => 'required',
            ];
            $data = $request->all();
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $order->firstname = $data['firstname'];
            $order->lastname = $data['lastname'];
            $order->email = $data['email'];
            $order->address = $data['address'];
            $order->country = $data['country'];
            $order->province = $data['province'];
            $order->city = $data['city'];
            $order->postcode = $data['postcode'];
            $order->phone = $data['phone'];
            $order->company = $data['company'];
            $order->comment = $data['comment'];
            $order->save();
            return $this->success('设置成功');
        }

        return view('admin.order.edit', [
            'pageTitle'  => $title,
            'order'      => $order,
            'countries'  => Helper::countries(),
            'statusList' => Order::$statusList,
        ]);
    }

    public function shipping($id, Request $request)
    {
        $title = '订单发货';

        $order = Order::find($id);

        if (!$order) {
            return $this->error('无效订单');
        }

        if ($request->isMethod('post')) {
            $order->express = (string) $request->express;
            $order->tracking_no = (string) $request->tracking_no;

            // update order status and change stocks
            if (in_array($order->status, ['pending', 'paid'])) {
                try {
                    $order->ship();
                } catch (\Exception $e) {
                    return $this->error($e->getMessage());
                }
            }

            return $this->success('设置成功');
        }

        return view('admin.order.shipping', [
            'pageTitle' => $title,
            'order'     => $order,
        ]);
    }

    public function pay($id, Request $request)
    {
        $title = '订单付款';

        $order = Order::find($id);

        if (!$order) {
            return $this->error('无效订单');
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;

            if ($data['currency'] != config('app.currency')) {
                try {
                    $data['exchange_rate'] = Helper::getExchangeRate(config('app.currency'), $data['currency']);
                } catch (\Exception $e) {
                    return $this->error($e->getMessage());
                }
            }

            $order->pay($data);

            return $this->success('设置成功');
        }

        return view('admin.order.pay', [
            'pageTitle' => $title,
            'order'     => $order,
        ]);
    }

    public function tracking($id)
    {
        $title = '快递跟踪';

        $order = Order::where('id', $id)->first();

        return view('admin.order.tracking', [
            'pageTitle' => $title,
            'order'     => $order,
        ]);
    }

    public function product($id)
    {
        $title = '订单商品';

        $order = Order::where('id', $id)->first();

        return view('admin.order.product', [
            'pageTitle' => $title,
            'order'     => $order,
        ]);
    }

    public function addProduct(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($request->isMethod('post')) {
            $rules = [
                'order_id'   => 'required|integer|min:1',
                'product_id' => 'required|integer|min:1',
                'quantity'   => 'required|integer|min:1',
                'price'      => 'required|numeric|min:0',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            OrderProduct::updateOrCreate(
                ['order_id' => $request->order_id, 'product_id' => $request->product_id],
                ['quantity' => $request->quantity, 'price' => $request->price]
            );

            $order->calculate();

            return $this->success('设置成功');
        }

        return view('admin.order.add_product', [
            'order' => $order,
        ]);
    }

    public function editProduct(Request $request)
    {
        if ($request->id) {
            $product = OrderProduct::find($request->id);
        }
        if (empty($product)) {
            $product = new OrderProduct;
        }

        if ($request->isMethod('post')) {
            $rules = [
                'quantity' => 'required|integer|min:1',
                'price'    => 'required|numeric|min:0',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->save();

            $order = Order::find($product->order_id);
            $order->calculate();

            return $this->success('设置成功');
        }

        return view('admin.order.edit_product', [
            'product' => $product,
        ]);
    }

    public function deleteProduct($id)
    {
        $product = OrderProduct::find($id);
        if (!$product) {
            return $this->error('订单不存在该商品');
        }

        try {
            $order = Order::find($product->order_id);
            $product->delete();
            $order->calculate();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getTemp(Request $request)
    {
        $title = '临时订单';
        $query = Order::whereNull('confirmed_at')->orderBy('id', 'desc');

        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('id', '=', $request->keyword)
                    ->orWhere('order_no', '=', $request->keyword);
            });
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->paginate(20);

        return view('admin.order.temp', [
            'pageTitle'  => $title,
            'data'       => $data,
            'params'     => $request->all(),
            'statusList' => Order::$statusList,
        ]);
    }

    public function recover($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->error('无效订单');
        }

        $order->recover();

        return $this->success('Order recovered!');
    }
}
