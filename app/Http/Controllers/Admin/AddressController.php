<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function getList(Request $request)
    {
        $title = "用户地址";

        $query = Address::where('user_id', $request->user_id)
            ->orderBy('is_default', 'desc')->orderBy('id', 'asc');

        $data = $query->paginate(20);

        return view('admin.address.list', [
            'pageTitle' => $title,
            'data'      => $data,
            'params'    => $request->all(),
        ]);
    }

    public function set(Request $request)
    {
        $title = "地址设置";

        if ($request->id) {
            $address = Address::find($request->id);
        }
        if (empty($address)) {
            $address          = new Address;
            $address->user_id = $request->user_id;
            $address->country = config('app.country');
        }

        if ($request->isMethod('post')) {
            $address->set($request->all());
            return $this->success('设置成功');
        }

        return view('admin.address.set', [
            'pageTitle' => $title,
            'address'   => $address,
            'countries' => Helper::countries(),
        ]);
    }

    public function delete($id)
    {
        $address = Address::find($id);
        if (!$address) {
            return $this->error('该地址不存在');
        }

        try {
            $address->delete();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
