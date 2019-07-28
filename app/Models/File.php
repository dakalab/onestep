<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    public function toKB()
    {
        return round($this->size / 1024);
    }

    public function fullpath()
    {
        $dir = config('filesystems.disks.' . config('filesystems.default') . '.root');
        return $dir . '/' . $this->path;
    }

    public function remove()
    {
        unlink($this->fullpath());
        return $this->delete();
    }
}
