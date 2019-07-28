<?php

namespace App\Models;

use Auth;
use Helper;
use Illuminate\Database\Eloquent\Model;
use Log;
use Ramsey\Uuid\Uuid;

class Cart extends Model
{
    protected $guarded = [];

    const CART_KEY = 'cart';

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    // merge cart1 into cart2 and then remove cart1
    public static function merge($id1, $id2)
    {
        $cart1 = self::where('raw_id', $id1)->get();
        if (count($cart1) == 0) {
            return;
        }

        $cart2 = self::where('raw_id', $id2)->get();
        if (count($cart2) == 0) {
            return self::where('raw_id', $id1)
                ->update([
                    'user_id' => Auth::user()->id,
                    'raw_id'  => $id2,
                ]);
        }

        foreach ($cart1 as $item) {
            $item2 = self::where('raw_id', $id2)
                ->where('product_id', $item->product_id)
                ->first();
            if ($item2) {
                $item2->quantity += $item->quantity;
                $item2->save();
            } else {
                $item->raw_id  = $id2;
                $item->user_id = Auth::user()->id;
                $item->save();
            }
        }

        return self::where('raw_id', $id1)->delete();
    }

    public static function rawID()
    {
        // get raw id from login account
        if (!Auth::guest()) {
            $item = self::where('user_id', Auth::user()->id)->first();
            if ($item) {
                if (session(self::CART_KEY) && session(self::CART_KEY) != $item->raw_id) {
                    self::merge(session(self::CART_KEY), $item->raw_id);
                }

                session([self::CART_KEY => $item->raw_id]);
                return $item->raw_id;
            }
        }

        // get raw id from session
        $rawID = session(self::CART_KEY);
        if ($rawID) {
            return $rawID;
        }

        // generate raw id for new shopping cart
        $rawID = Uuid::uuid1();
        session([self::CART_KEY => $rawID]);

        return $rawID;
    }

    public static function getQuery()
    {
        return self::where('raw_id', self::rawID());
    }

    public static function getItems()
    {
        return self::getQuery()->get();
    }

    public static function countItems()
    {
        return self::getQuery()->sum('quantity');
    }

    public function subtotal()
    {
        return Helper::money(round($this->product->price * $this->quantity, 2), session('currency'));
    }

    public static function total()
    {
        $total = 0;
        foreach (self::getItems() as $item) {
            $total += $item->product->price * $item->quantity;
        }
        return round($total, 2);
    }

    public static function totalMoney()
    {
        return Helper::money(self::total(), session('currency'));
    }

    public static function lastest()
    {
        $qty = $total = 0;
        foreach (self::getItems() as $item) {
            $product = $item->product;
            if (!$product || $product->getAttribute('hidden')) {
                Log::info('item id: ' . $item->id);
                $item->delete();
            } else {
                $qty += $item->quantity;
                $total += $product->price * $item->quantity;
            }
        }
        return ['qty' => $qty, 'total' => $total];
    }
}
