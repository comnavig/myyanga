<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    public function getUrlAttribute($value)
    {
        if (!$value) return null;
        if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }
        return \Illuminate\Support\Facades\Storage::disk('public')->url($value);
    }
}
