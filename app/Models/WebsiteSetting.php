<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $guarded = [];

    public static function getValue($key)
    {
        $s = self::where('key', $key)->first();
        return $s ? $s->value : '';
    }

    public static function getLogo()
    {
        $logo = self::getValue('logo');
        if (!$logo) {
            return url('/img/boxed-bg.png');
        }
        $photo = Photo::find($logo);
        if (!$photo) {
            return url('/img/boxed-bg.png');
        }
        return $photo->url();
    }
}
