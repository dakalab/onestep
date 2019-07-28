<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Wishlist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [];

        if ($request->seo) {
            $product = Product::where('seo_url', $request->seo)->first();
        } else {
            $product = Product::find($request->id);
        }

        if (!$product) {
            return redirect('/fail')->withErrors(__('product.not_exist'));
        }

        $product->viewed++;
        $product->save();

        $category = Category::find($product->category_id);
        if ($category) {
            $breadcrumbs[] = [
                'url'  => $category->url(),
                'name' => $category->name,
            ];
        }

        $breadcrumbs[] = [
            'url'  => '#',
            'name' => $product->name,
        ];

        $photos = [];
        foreach ($product->photos as $photo) {
            $photos[] = [
                'url'  => $photo->url(),
                'name' => $product->name,
            ];
        }
        if (empty($photos)) {
            $photos[] = ['url' => config('product.empty_photo'), 'name' => $product->name];
        }

        return view('web.product', [
            'pageTitle'   => $product->name,
            'categories'  => Category::where('hidden', 0)->orderBy('name')->get(),
            'params'      => $request->all(),
            'product'     => $product,
            'breadcrumbs' => $breadcrumbs,
            'photos'      => $photos,
            'ratings'     => $product->ratings(),
        ]);
    }

    public function review(Request $request)
    {
        $rules = [
            'product_id' => 'required|integer',
            'author'     => 'required',
            'rating'     => 'required|integer',
            'comment'    => 'required|min:5',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        ProductReview::create([
            'product_id'   => (int) $request->product_id,
            'author'       => $request->author,
            'rating'       => $request->rating,
            'comment'      => $request->comment,
            'hidden'       => (int) $request->hidden,
            'user_id'      => (int) Auth::user()->id,
            'comment_time' => date('Y-m-d'),
        ]);

        return $this->success(__('product.thx_review'));
    }

    public function wishlist(Request $request)
    {
        if (Auth::guest()) {
            return $this->error(__('product.need_login'));
        }

        Wishlist::firstOrCreate([
            'product_id' => (int) $request->product_id,
            'user_id'    => (int) Auth::user()->id,
        ]);

        return $this->success(__('product.wishlist_added'));
    }
}
