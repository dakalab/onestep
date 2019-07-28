<?php

namespace App\Models;

use App\User;
use Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Validator;

class Stock extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function operator()
    {
        if (!$this->user_id) {
            return '';
        }
        return $this->user->name;
    }

    public static function change($data)
    {
        $rules = [
            'product_id' => 'required|integer|min:1',
            'change'     => 'required|integer',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $product = Product::find($data['product_id']);
        if (!$product) {
            throw ValidationException::withMessages(['该商品不存在']);
        }

        $product->quantity += $data['change'];
        // if ($product->quantity < 0) {
        //     throw new \Exception('商品ID ' . $product->id . ' 的库存不足，不能发货');
        // }

        if (empty($data['currency'])) {
            $data['currency'] = config('app.currency');
        }

        $data['exchange_rate'] = 1;
        if ($data['currency'] != config('app.currency')) {
            $data['exchange_rate'] = Helper::getExchangeRate(config('app.currency'), $data['currency']);
        }

        Stock::create($data);

        if ($data['change'] < 0) {
            $product->sales -= $data['change'];
        }
        $product->save();
    }
}
