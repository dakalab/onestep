<?php

namespace App\Models;

use Helper;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function detail()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function money()
    {
        return Helper::money($this->price, session('currency'));
    }

    public function subtotal()
    {
        return Helper::money(round($this->price * $this->quantity, 2), session('currency'));
    }
}
