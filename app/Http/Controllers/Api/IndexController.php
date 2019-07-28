<?php

namespace App\Http\Controllers\Api;

use App\Helper;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function version(Request $request)
    {
        $this->getLogger()->debug("[" . $request->path() . "] got it");
        return $this->success('ok', ['version' => '1.0']);
    }

    public function provinces(Request $request)
    {
        $country = $request->input('country', config('app.country'));

        $provinces = Helper::states($country);

        return $this->success('ok', $provinces);
    }

    public function products(Request $request)
    {
        $limit = 10;
        $query = Product::where('hidden', 0)->orderBy('name', 'asc');

        if ($request->term) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->term . '%')
                    ->orWhere('id', '=', $request->term)
                    ->orWhere('sku', 'like', $request->term . '%')
                    ->orWhere('spu', 'like', $request->term . '%');
            });
        }

        $products = $query->paginate($limit);

        $data = [];
        foreach ($products as $product) {
            $data['results'][] = [
                'id'   => $product->id,
                'text' => $product->name,
            ];
        }
        if (!empty($data['results']) && count($data['results']) >= $limit) {
            $data['pagination']['more'] = true;
        } else {
            $data['pagination']['more'] = false;
        }

        return response()->json($data);
    }

    public function product($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([]);
        }

        return response()->json($product->toArray());
    }
}
