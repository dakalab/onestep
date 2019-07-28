<?php

namespace App\Http\Controllers\Admin;

use App\Models\AttributeGroup;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class ProductController extends Controller
{
    public function getList(Request $request)
    {
        $title = '商品列表';

        $exportURL = url('/downloads/products.xlsx');

        $orderBy = $request->input('order_by', 'id');
        $sort = $request->input('sort', 'desc');

        $query = Product::orderBy($orderBy, $sort);

        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', '=', $request->keyword)
                    ->orWhere('sku', '=', $request->keyword)
                    ->orWhere('spu', '=', $request->keyword);
            });
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
            $exportURL = url('/downloads/' . $request->category_id . '_products.xlsx');
        }
        if ($request->status) {
            $query->where('hidden', $request->status - 1);
        }

        $data = $query->paginate(20);

        $sortable = [
            'sku'      => 'SKU',
            'spu'      => '编号',
            'name'     => '名称',
            'price'    => '价格',
            'quantity' => '库存',
            'sales'    => '销量',
            'viewed'   => '点击',
        ];

        return view('admin.product.list', [
            'pageTitle'  => $title,
            'data'       => $data,
            'categories' => Category::orderBy('name')->get(),
            'params'     => $request->all(),
            'sortable'   => $sortable,
            'exportURL'  => $exportURL,
        ]);
    }

    public function set(Request $request)
    {
        $title = '商品设置';

        if ($request->id) {
            $product = Product::find($request->id);
        }
        if (empty($product)) {
            $product = new Product;
        }

        if ($request->isMethod('post')) {
            $rules = [
                'name'        => 'required',
                'sku'         => 'required',
                'category_id' => 'required|integer',
                'price'       => 'required|numeric|min:0',
            ];
            if (!$product->sku || $product->sku != $request->sku) {
                $rules['sku'] = 'required|unique:products';
            }
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $product->name = $request->name;
            $product->sku = $request->sku;
            $product->spu = $request->spu ?: $request->sku;
            $product->price = $request->price;
            $product->hidden = $request->hidden;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->keywords = $request->keywords;
            $product->meta_desc = $request->meta_desc;

            if ($request->seo_url) {
                $product->seo_url = $request->seo_url;
            }

            if (!$product->seo_url) {
                $product->seo_url = $product->seo();
            }

            $product->save();

            $product->updateAttributes($request->input('attributes', []));

            return $this->success('设置成功');
        }

        $attributes = array_pluck($product->attributes->toArray(), 'id');

        return view('admin.product.set', [
            'pageTitle'  => $title,
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
            'groups'     => AttributeGroup::get(),
            'attributes' => $attributes,
        ]);
    }

    public function stop($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->error('该商品不存在');
        }

        try {
            $product->hidden = 1;
            $product->save();
            return $this->success('下架成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->error('该商品不存在');
        }

        try {
            $product->remove();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function getPhotos($id)
    {
        $title = '商品图片';

        $product = Product::find($id);
        if (!$product) {
            return redirect('/admin/fail')->withErrors('该商品不存在');
        }

        return view('admin.product.photos', [
            'pageTitle' => $title,
            'product'   => $product,
        ]);
    }

    public function import(Request $request)
    {
        $title = '商品导入';

        if ($request->isMethod('post')) {
            if (!$request->hasFile('file')) {
                return $this->error('没有上传文件');
            }

            $data = [];
            $data['filename'] = $request->file->getClientOriginalName();
            $data['extension'] = $request->file->extension();
            $data['size'] = $request->file->getSize();
            $data['path'] = $request->file->store('files');
            $data['user_id'] = Auth::user()->id;
            File::create($data);

            return $this->success('导入成功');
        }

        return view('admin.product.import', [
            'pageTitle' => $title,
        ]);
    }
}
