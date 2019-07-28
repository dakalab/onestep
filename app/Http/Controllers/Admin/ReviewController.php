<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class ReviewController extends Controller
{
    public function getList(Request $request)
    {
        $title = "商品评论";

        $query = ProductReview::orderBy('id', 'desc');

        $data = $query->paginate(20);

        return view('admin.review.list', [
            'pageTitle' => $title,
            'data'      => $data,
            'params'    => $request->all(),
        ]);
    }

    public function set(Request $request)
    {
        $title = "评论编辑";

        if ($request->id) {
            $review = ProductReview::find($request->id);
        }
        if (empty($review)) {
            $review = new ProductReview;
        }

        if ($request->isMethod('post')) {
            $rules = [
                'author'  => 'required',
                'rating'  => 'required|integer|min:1',
                'comment' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $review->product_id   = (int) $request->product_id;
            $review->author       = $request->author;
            $review->rating       = $request->rating;
            $review->comment      = $request->comment;
            $review->hidden       = (int) $request->hidden;
            $review->comment_time = $request->comment_time;
            $review->save();

            return $this->success('设置成功');
        }

        return view('admin.review.set', [
            'pageTitle' => $title,
            'review'    => $review,
        ]);
    }

    public function delete($id)
    {
        $review = ProductReview::find($id);
        if (!$review) {
            return $this->error('该评论不存在');
        }

        try {
            $review->delete();
            return $this->success('删除成功');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
