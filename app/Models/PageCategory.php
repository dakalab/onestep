<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageCategory extends Model
{
    protected $guarded = [];

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('sort', 'asc');
    }

    public function remove()
    {
        if ($this->pages()->count() > 0) {
            throw new \Exception('该分类下面有页面，不能删除');
        }
        return $this->delete();
    }
}
