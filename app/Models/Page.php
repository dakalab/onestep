<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(PageCategory::class, 'page_category_id');
    }

    public function url()
    {
        if (!$this->seo_url) {
            return url('/page/' . $this->id);
        }
        return '/' . $this->seo_url;
    }
}
