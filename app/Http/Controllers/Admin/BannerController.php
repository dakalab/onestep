<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class BannerController extends Controller
{
    public function getList(Request $request)
    {
        $title = "广告设置";

        $query = Banner::orderBy('id', 'desc');

        if ($request->status) {
            $query->where('hidden', $request->status - 1);
        }

        $data = $query->paginate(20);

        return view('admin.banner.list', [
            'pageTitle' => $title,
            'data'      => $data,
            'params'    => $request->all(),
        ]);
    }

    public function set(Request $request)
    {
        $title = "广告设置";

        if ($request->id) {
            $banner = Banner::find($request->id);
        }
        if (empty($banner)) {
            $banner = new Banner;
        }

        if ($request->isMethod('post')) {
            $rules = [
                'name'     => 'required',
                'photo_id' => 'required|integer',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $banner->name     = $request->name;
            $banner->url      = $request->url;
            $banner->photo_id = $request->photo_id;
            $banner->hidden   = (int) $request->hidden;

            if (empty($banner->url)) {
                $banner->url = '#';
            }

            $banner->save();

            return $this->success('设置成功');
        }

        return view('admin.banner.set', [
            'pageTitle' => $title,
            'banner'    => $banner,
        ]);
    }

    public function delete($id)
    {
        $banner = banner::find($id);
        if (!$banner) {
            return $this->error('该广告不存在');
        }

        try {
            $banner->remove();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
