<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getList()
    {
        $title = "商品分类";
        $query = Category::orderBy('sort', 'desc')->orderBy('name', 'asc');
        $data  = $query->paginate(20);

        return view('admin.category.list', [
            'pageTitle' => $title,
            'data'      => $data,
        ]);
    }

    public function set(Request $request)
    {
        $title = "分类设置";

        if ($request->input('id')) {
            $category = Category::find($request->input('id'));
        }
        if (empty($category)) {
            $category = new Category;
        }

        if ($request->isMethod('post')) {
            $category->name   = $request->input('name');
            $category->hidden = (int) $request->input('hidden');
            $category->sort   = (int) $request->input('sort');
            $category->save();

            return $this->success('设置成功');
        }

        return view('admin.category.set', [
            'pageTitle' => $title,
            'category'  => $category,
        ]);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->error('该分类不存在');
        }

        try {
            $category->remove();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
