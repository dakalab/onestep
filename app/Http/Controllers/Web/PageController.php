<?php

namespace App\Http\Controllers\Web;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($id, Request $request)
    {
        $breadcrumbs = [];

        $page = Page::find($id);
        if (!$page) {
            $page = page::where('seo_url', $id . '.html')->first();
        }

        if (!$page) {
            return redirect('/404');
        }

        $breadcrumbs[] = [
            'url'  => '#',
            'name' => $page->title,
        ];

        return view('web.page', [
            'pageTitle'   => $page->title,
            'page'        => $page,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
