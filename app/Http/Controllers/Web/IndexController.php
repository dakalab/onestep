<?php

namespace App\Http\Controllers\Web;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    // Show the home page.
    public function index(Request $request)
    {
        $title       = __('index.home');
        $breadcrumbs = [];

        $orderBy = $request->input('order_by', 'id');
        $sort    = $request->input('sort', 'desc');

        $query = Product::where('hidden', 0)->orderBy($orderBy, $sort);

        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);

            $category = Category::find($request->category_id);
            if ($category) {
                $title         = $category->name;
                $breadcrumbs[] = [
                    'url'  => $category->url(),
                    'name' => $category->name,
                ];
            }
        }

        $products = $query->paginate(15);

        if (!empty($category)) {
            $pagination = $products->withPath($category->url());
        } else {
            $pagination = $products->appends($request->all());
        }

        if ($request->keyword) {
            $pagination->appends(['keyword' => $request->keyword]);
        }

        if ($request->page > 1) {
            $title .= ' Page ' . $request->page;
        }

        return view('web.index', [
            'pageTitle'   => $title,
            'banners'     => Banner::where('hidden', 0)->orderBy('id')->get(),
            'categories'  => Category::where('hidden', 0)->orderBy('sort', 'desc')->orderBy('name', 'asc')->get(),
            'params'      => $request->all(),
            'products'    => $products,
            'breadcrumbs' => $breadcrumbs,
            'pagination'  => $pagination->links(),
        ]);
    }

    // site map page
    public function sitemap(Request $request)
    {
        return view('web.sitemap', [
            'pageTitle'  => 'Site Map',
            'categories' => Category::where('hidden', 0)->orderBy('sort', 'desc')->orderBy('name', 'asc')->get(),
        ]);
    }

    // Show the sitemap xml.
    public function sitemapXML(Request $request)
    {
        // create new sitemap object
        $sitemap = app('sitemap');

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled
        // $sitemap->setCache('laravel.sitemap', 60);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached()) {
            // add item to the sitemap (url, date, priority, freq)
            $sitemap->add(url('/'), date('c'), '1.0', 'daily');
            $sitemap->add(url('about.html'), date('c'), '0.9', 'monthly');
        }

        // get all categories from db
        $categories = Category::where('hidden', 0)->orderBy('sort', 'desc')->orderBy('name', 'asc')->get();

        // add categories to the sitemap
        foreach ($categories as $category) {
            $sitemap->add($category->url(), date('c', strtotime($category->updated_at)), '1.0', 'daily');
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');
    }
}
