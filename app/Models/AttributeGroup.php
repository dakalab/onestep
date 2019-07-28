<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    protected $guarded = [];

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function remove()
    {
        if ($this->attributes()->count() > 0) {
            throw new \Exception('该分组下面有属性，不能删除');
        }
        return $this->delete();
    }
}
