<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'hidden'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function remove()
    {
        if ($this->products()->count() > 0) {
            throw new \Exception('该分类下面有商品，不能删除');
        }
        return $this->delete();
    }

    public function seo()
    {
        $seo = strtolower(preg_replace(['/-|\./', '/\s+/'], [' ', '-'], $this->name));
        $seo .= '_' . $this->id;

        return $seo;
    }

    public function url()
    {
        return url('/c/' . $this->seo());
    }

    public function countProducts()
    {
        return (int) Product::where('hidden', 0)
            ->where('category_id', $this->id)->count();
    }
}
