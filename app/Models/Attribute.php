<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $guarded = [];

    public function attributeGroup()
    {
        return $this->belongsTo(AttributeGroup::class, 'attribute_group_id');
    }

    public function remove()
    {
        if ($this->attributes()->count() > 0) {
            throw new \Exception('该分组下面有属性，不能删除');
        }
        return $this->delete();
    }
}
