<?php

namespace App\Http\Controllers\Admin;

use App\Models\PageCategory;
use Illuminate\Http\Request;

class PageCategoryController extends Controller
{
    public function getList()
    {
        $title = "页面分类";
        $data  = PageCategory::paginate(20);

        return view('admin.page_category.list', [
            'pageTitle' => $title,
            'data'      => $data,
        ]);
    }

    public function set(Request $request)
    {
        $title = "分类设置";

        if ($request->input('id')) {
            $category = PageCategory::find($request->input('id'));
        }
        if (empty($category)) {
            $category = new PageCategory;
        }

        if ($request->isMethod('post')) {
            $category->name = $request->input('name');
            $category->save();

            return $this->success('设置成功');
        }

        return view('admin.page_category.set', [
            'pageTitle' => $title,
            'category'  => $category,
        ]);
    }

    public function delete($id)
    {
        $category = PageCategory::find($id);
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
