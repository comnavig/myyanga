<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    public static function getUrl($disk, $path)
    {
        if (!$path) return null;
        
        // If it's already an absolute URL, return it
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $storageDisk */
        $storageDisk = Storage::disk($disk);
        
        // If using S3, generate a temporary presigned URL (valid for 24 hours)
        if (env('FILESYSTEM_DRIVER', 'local') === 's3') {
            return $storageDisk->temporaryUrl($path, now()->addHours(24));
        }

        // Otherwise, use standard local URL
        return $storageDisk->url($path);
    }
}
