<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Stock;
use Auth;
use DB;
use Helper;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function getList($productID)
    {
        $product = Product::find($productID);
        if (!$product) {
            return redirect('/admin/fail')->withErrors('该商品不存在');
        }

        $title = "库存记录";
        $query = Stock::where('product_id', $productID)->orderBy('id', 'desc');
        $data  = $query->paginate(20);

        return view('admin.stock.list', [
            'pageTitle' => $title,
            'data'      => $data,
            'product'   => $product,
        ]);
    }

    public function set($productID, Request $request)
    {
        $title = "增减库存";

        $product = Product::find($productID);
        if (!$product) {
            return $this->error('该商品不存在');
        }

        if ($request->isMethod('post')) {
            if ($product->quantity + $request->change < 0) {
                return $this->error('库存数量不足');
            }

            DB::transaction(function () use ($product, $request) {
                Stock::change([
                    'product_id' => $product->id,
                    'change'     => $request->change,
                    'unit_cost'  => (float) $request->unit_cost,
                    'currency'   => $request->currency,
                    'remark'     => $request->remark,
                    'user_id'    => Auth::user()->id,
                ]);
            });

            return $this->success('设置成功');
        }

        return view('admin.stock.set', [
            'pageTitle' => $title,
            'product'   => $product,
        ]);
    }

    public function edit($id, Request $request)
    {
        $title = "编辑库存记录";

        $s = Stock::find($id);

        if (!$s) {
            return $this->error('该库存记录不存在');
        }

        if ($request->isMethod('post')) {
            $s->currency      = $request->currency;
            $s->unit_cost     = (float) $request->unit_cost;
            $s->exchange_rate = Helper::getExchangeRate(config('app.currency'), $s->currency);
            $s->save();

            return $this->success('设置成功');
        }

        return view('admin.stock.edit', [
            'pageTitle' => $title,
            'stock'     => $s,
        ]);
    }

    public function check(Request $request)
    {
        $title = "库存盘点";

        $query = Stock::orderBy('id', 'desc');

        if ($request->start) {
            $query->where('created_at', '>=', $request->start);
        }
        if ($request->end) {
            $query->where('created_at', '<=', $request->end . " 23:59:59");
        }

        $data = $query->paginate(20);

        $stats = Stock::select(
            DB::raw('
                round(sum(`change`)) as total_num,
                round(sum(`unit_cost` * `change` * `exchange_rate`), 2) as total_amount
            ')
        )->where('change', '>', 0)->first();

        $remains = Product::select(
            DB::raw('
                round(sum(`quantity`)) as total_num,
                round(sum(`price` * `quantity`), 2) as total_amount
            ')
        )->where('quantity', '>', 0)->first();

        $sales = Stock::select(
            DB::raw('
                -round(sum(`change`)) as total_num,
                -round(sum(`unit_cost` * `change` * `exchange_rate`), 2) as total_amount
            ')
        )->where('change', '<', 0)->first();

        return view('admin.stock.check', [
            'pageTitle' => $title,
            'data'      => $data,
            'stats'     => $stats,
            'remains'   => $remains,
            'sales'     => $sales,
            'start'     => $request->start,
            'end'       => $request->end,
        ]);
    }
}
