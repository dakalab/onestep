<?php

namespace App\Models;

use Helper;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!$this->transaction_no) {
            $this->transaction_no = $this->generateTransactionNO();
        }
    }

    public function generateTransactionNO()
    {
        return date('Ymd') . '-' . Helper::randomStr(4);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function money()
    {
        return Helper::money(round($this->amount * $this->exchange_rate, 2));
    }
}
