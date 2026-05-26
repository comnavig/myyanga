<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $settings_image_ = [
        'name',
        'value',
    ];

    /**
     * Dynamically resolve settings values (like Logo/Background images) on the fly.
     */
    // Note: If "name" column in `settings` table changes, we need to update the 'name' check in the method below.
    public function getValueAttribute($value)
    {
        if (in_array($this->name, ['logo', 'background_1']) && $value && !\Illuminate\Support\Str::startsWith($value, ['http://', 'https://'])) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = \Illuminate\Support\Facades\Storage::disk('public');
            return $disk->url($value);
        }

        return $value;
    }
}
