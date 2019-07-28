<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Photo extends Model
{
    protected $guarded = [];

    public function toKB()
    {
        return round($this->size / 1024);
    }

    public function url()
    {
        return asset('storage/' . $this->path);
    }

    public function remove()
    {
        $num = ProductPhoto::where('photo_id', $this->id)->count();
        if ($num > 0) {
            // 该图片有关联商品，不删除直接返回
            return 0;
        }

        $num = Banner::where('photo_id', $this->id)->count();
        if ($num > 0) {
            // 该图片有关联广告，不删除直接返回
            return 0;
        }

        $num = WebsiteSetting::where('value', $this->id)->count();
        if ($num > 0) {
            // 该图片有关联logo，不删除直接返回
            return 0;
        }

        $dir = config('filesystems.disks.' . config('filesystems.default') . '.root');
        @unlink($dir . '/' . $this->path);
        return $this->delete();
    }

    public static function generatePathAndName($extension)
    {
        if ($extension == 'jpeg') {
            $extension = 'jpg';
        }

        $hash = strtolower(Str::random(40));

        $path = 'images/' . substr($hash, 0, 2) . '/' . substr($hash, 2, 2);
        $dir = config('filesystems.disks.' . config('filesystems.default') . '.root') . '/';
        @mkdir($dir . $path, 0777, true);

        return [
            'path' => $path,
            'name' => $hash . '.' . $extension,
        ];
    }
}
