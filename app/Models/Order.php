<?php

namespace App\Models;

use App\User;
use Auth;
use DB;
use Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;
use Validator;

class Order extends Model
{
    use SoftDeletes;

    public static $statusList = [
        'pending', 'paid', 'shipped', 'complete', 'canceled', 'refunded', 'expired',
    ];

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!$this->order_no) {
            $this->order_no = $this->generateOrderNO();
        }
    }

    public function fullPhone()
    {
        if (empty($this->phone)) {
            return '';
        }
        $dialingCode = Helper::dialingCode($this->country);
        if (empty($dialingCode)) {
            return $this->phone;
        }
        return '+' . $dialingCode . '-' . $this->phone;
    }

    public function generateOrderNO()
    {
        return date('Ymd') . '-' . Helper::randomStr(4);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addProduct($product, $quantity = 1)
    {
        return OrderProduct::updateOrCreate([
            'order_id'   => $this->id,
            'product_id' => $product->id,
            'quantity'   => $quantity,
            'price'      => $product->price,
        ]);
    }

    public function setData($data = [])
    {
        $this->shipping_method = array_get($data, 'shipping_method', 'free');
        $this->payment_method = array_get($data, 'payment_method', 'paypal');
        $this->comment = array_get($data, 'comment');
        $this->currency = array_get($data, 'currency', config('app.currency'));
        $this->exchange_rate = array_get($data, 'exchange_rate', 1);
        return $this;
    }

    public function setAddress($data)
    {
        $rules = [
            'firstname' => 'required',
            'lastname'  => 'required',
            'address'   => 'required|min:10',
            'country'   => 'required',
            'city'      => 'required',
            'postcode'  => 'required',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->address = $data['address'];
        $this->country = $data['country'];
        $this->province = $data['province'];
        $this->city = $data['city'];
        $this->postcode = $data['postcode'];
        $this->phone = $data['phone'];
        $this->company = $data['company'];

        return $this;
    }

    public function setEmptyAddress()
    {
        $this->firstname = '';
        $this->lastname = '';
        $this->address = '';
        $this->country = '';
        $this->province = '';
        $this->city = '';
        $this->postcode = '';
    }

    public function concatAddress()
    {
        $arr = [];
        if (!empty($this->address)) {
            $arr[] = $this->address;
        }
        if (!empty($this->city)) {
            $arr[] = $this->city;
        }
        if (!empty($this->province)) {
            $arr[] = $this->province;
        }
        if (!empty($this->country)) {
            $arr[] = $this->country;
        }
        return implode(', ', $arr);
    }

    public function calculate()
    {
        $this->product_amount = $this->products()->sum(DB::raw('price * quantity'));
        $this->total = $this->product_amount + $this->shipping_fee + $this->tax;
        $this->save();
    }

    public function updateStock()
    {
        DB::transaction(function () {
            foreach ($this->products as $product) {
                Stock::change([
                    'order_id'   => $this->id,
                    'product_id' => $product->product_id,
                    'change'     => -$product->quantity,
                    'unit_cost'  => (float) $product->price,
                    'currency'   => $this->currency,
                    'remark'     => '发货扣减',
                    'user_id'    => Auth::user()->id,
                ]);
            }
        });
        $this->status = 'shipped';
    }

    public function productMoney()
    {
        return Helper::money($this->product_amount, session('currency'));
    }

    public function totalMoney()
    {
        return Helper::money($this->total, session('currency'));
    }

    public function paidMoney()
    {
        return Helper::money($this->paid_amount, session('currency'));
    }

    public function showStatus()
    {
        $color = 'default';
        if (in_array($this->status, ['shipped', 'complete'])) {
            $color = 'success';
        } elseif (in_array($this->status, ['paid'])) {
            $color = 'info';
        } elseif ($this->status == 'expired') {
            $color = 'warning';
        } elseif (in_array($this->status, ['canceled', 'refunded'])) {
            $color = 'danger';
        }

        return "<span class=\"label label-$color\">" . $this->status . '</span>';
    }

    public function editable()
    {
        return !in_array($this->status, ['complete', 'refunded']);
    }

    public function cancelable()
    {
        return !in_array($this->status, ['canceled', 'refunded', 'expired']);
    }

    public function shippable()
    {
        return in_array($this->status, ['pending', 'paid']);
    }

    public function payable()
    {
        return $this->status == 'pending';
    }

    public function trackable()
    {
        return !empty($this->tracking_no);
    }

    public function refundable()
    {
        return in_array($this->status, ['paid', 'shipped']);
    }

    public function pay($data)
    {
        DB::transaction(function () use ($data) {
            $transaction = Transaction::create([
                'transaction_no' => array_get($data, 'transaction_no'),
                'user_id'        => array_get($data, 'user_id', $this->user_id),
                'order_id'       => $this->id,
                'amount'         => array_get($data, 'amount', $this->total),
                'currency'       => array_get($data, 'currency', config('app.currency')),
                'exchange_rate'  => array_get($data, 'exchange_rate', 1),
                'description'    => array_get($data, 'description'),
                'token'          => array_get($data, 'token'),
                'payer_id'       => array_get($data, 'payer_id'),
            ]);
            if ($transaction) {
                $this->status = 'paid';
                $this->paid_amount += round($transaction->amount * $transaction->exchange_rate, 2);
                $this->save();
            }
        });
    }

    public static function expire()
    {
        self::where('status', 'pending')
            ->where('created_at', '<=', date('Y-m-d H:i:s', strtotime('-1 day')))
            ->update(['status' => 'expired']);
    }

    public function tracking()
    {
        return Helper::track($this->tracking_no, $this->express);
    }

    public function ship()
    {
        if (!$this->tracking_no) {
            throw new \Exception('发货失败：快递单号不能为空');
        }
        if (!$this->express) {
            $this->express = 'DHL';
        }

        $this->updateStock();
        return $this->save();
    }

    public function recover()
    {
        $this->confirmed_at = $this->created_at;
        return $this->save();
    }
}
