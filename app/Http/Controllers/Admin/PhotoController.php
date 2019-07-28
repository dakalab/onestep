<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Image;
use Validator;

class PhotoController extends Controller
{
    public function getList()
    {
        $title = "图片列表";
        $query = Photo::orderBy('id', 'desc');
        $data  = $query->paginate(20);

        return view('admin.photo.list', [
            'pageTitle' => $title,
            'data'      => $data,
        ]);
    }

    public function upload(Request $request)
    {
        $title = "图片上传";

        if (!$request->hasFile('photo')) {
            return $this->error('上传参数错误');
        }

        $rules['photo'] = 'required|image';
        $validator      = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // crop and resize the image which size is larger than 500kb
        if ($request->photo->getSize() > 500 * 1024) {
            $img = Image::make($request->photo->getPathname())->fit(500, 500)->save();
        }

        $data['filename']  = $request->photo->getClientOriginalName();
        $data['extension'] = $request->photo->extension();
        $data['md5']       = md5_file($request->photo->getPathname());

        try {
            // prevent upload duplicate file
            $photo = Photo::where('md5', $data['md5'])->first();
            if (!$photo) {
                $pn           = Photo::generatePathAndName($data['extension']);
                $data['path'] = $request->photo->storeAs($pn['path'], $pn['name']);
                $data['size'] = filesize(config('filesystems.disks.public.root') . '/' . $data['path']);
                $photo        = Photo::create($data);
            }

            // link to product
            if ($request->product_id) {
                ProductPhoto::firstOrCreate([
                    'product_id' => $request->product_id,
                    'photo_id'   => $photo->id,
                ]);
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

        return $this->success('上传成功', ['id' => $photo->id, 'url' => $photo->url()]);
    }

    public function delete(Request $request)
    {
        // unlink the photo and product
        if ($request->product_id > 0) {
            ProductPhoto::where('product_id', $request->product_id)
                ->where('photo_id', $request->photo_id)
                ->delete();
        }

        $photo = Photo::find($request->photo_id);
        if ($photo) {
            try {
                $photo->remove();
                return $this->success('删除成功');
            } catch (\Exception $e) {
                return $this->error($e->getMessage());
            }
        }

        return $this->error('该图片不存在');
    }

    public function view($id)
    {
        $photo = Photo::find($id);
        return view('admin.photo.view', [
            'photo' => $photo,
        ]);
    }
}
