<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = [];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function remove()
    {
        $photo = $this->photo;
        $this->delete();
        return $photo->remove();
    }
}
