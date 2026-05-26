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
        
        // Return standard URL (which dynamically resolves to S3 proxy or local based on environment)
        return $storageDisk->url($path);
    }
}
