<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\PageCategory;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class PageController extends Controller
{
    public function getList(Request $request)
    {
        $title = "页面列表";

        $query = Page::orderBy('page_category_id', 'asc')->orderBy('sort', 'asc');

        $data = $query->paginate(20);

        return view('admin.page.list', [
            'pageTitle' => $title,
            'data'      => $data,
        ]);
    }

    public function set(Request $request)
    {
        $title = "页面编辑";

        if ($request->id) {
            $page = Page::find($request->id);
        }
        if (empty($page)) {
            $page = new Page;
        }

        if ($request->isMethod('post')) {
            $rules = [
                'title'   => 'required',
                'seo_url' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $page->page_category_id = $request->page_category_id;
            $page->title            = $request->title;
            $page->content          = $request->content;
            $page->keywords         = $request->keywords;
            $page->meta_desc        = $request->meta_desc;
            $page->seo_url          = $request->seo_url;
            $page->sort             = (int) $request->sort;
            $page->user_id          = Auth::user()->id;
            $page->save();

            return $this->success('保存成功');
        }

        return view('admin.page.set', [
            'pageTitle'  => $title,
            'page'       => $page,
            'categories' => PageCategory::get(),
        ]);
    }

    public function delete($id)
    {
        $page = Page::find($id);
        if (!$page) {
            return $this->error('该页面不存在');
        }

        try {
            $page->delete();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
