<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Validator;

class Address extends Model
{
    protected $guarded = [];

    public function set($data)
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

        $this->firstname  = $data['firstname'];
        $this->lastname   = $data['lastname'];
        $this->address    = $data['address'];
        $this->country    = $data['country'];
        $this->province   = $data['province'];
        $this->city       = $data['city'];
        $this->postcode   = $data['postcode'];
        $this->phone      = $data['phone'];
        $this->company    = $data['company'];
        $this->is_default = (int) array_get($data, 'is_default', 0);
        $this->save();

        // make sure there is exactly only one default address
        if ($this->is_default) {
            Address::where('user_id', $this->user_id)
                ->where('id', '<>', $this->id)
                ->where('is_default', 1)
                ->update(['is_default' => 0]);
        } else {
            $c = Address::where('user_id', $this->user_id)
                ->where('id', '<>', $this->id)
                ->where('is_default', 1)
                ->count();
            if ($c == 0) {
                $this->is_default = 1;
                $this->save();
            }
        }

        return $this;
    }
}
