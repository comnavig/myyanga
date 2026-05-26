<?php

/*
|--------------------------------------------------------------------------
| Shared S3 Configuration
|--------------------------------------------------------------------------
|
| These variables are shared across all disks that can dynamically
| switch between local and S3 storage. Set FILESYSTEM_DRIVER=s3
| in your .env to activate cloud storage (Railway, AWS, R2, etc).
|
*/

$isS3 = env('FILESYSTEM_DRIVER', 'local') === 's3';

$s3Credentials = [
    'key'      => env('AWS_ACCESS_KEY_ID'),
    'secret'   => env('AWS_SECRET_ACCESS_KEY'),
    'region'   => env('AWS_DEFAULT_REGION'),
    'bucket'   => env('AWS_BUCKET'),
    'endpoint' => env('AWS_ENDPOINT'),
];

/**
 * Build a disk config that switches between local and S3.
 *
 * @param string $folder The subfolder name (e.g. 'avatar', 'posts'). Leave empty for the root public disk.
 */
$cloudDisk = function (string $folder = '') use ($isS3, $s3Credentials) {
    $suffix = $folder !== '' ? '/' . $folder : '';

    $config = [
        'driver'     => $isS3 ? 's3' : 'local',
        'root'       => $isS3 ? $folder : storage_path('app/public' . $suffix),
        'visibility' => 'public',
    ];

    $config['url'] = env('AWS_URL')
        ? env('AWS_URL') . $suffix
        : env('APP_URL') . '/storage' . $suffix;

    return $isS3 ? array_merge($config, $s3Credentials) : $config;
};

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),
    //~ 'default' => env('FILESYSTEM_DRIVER', 'do'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => $cloudDisk(),
        'temp'   => $cloudDisk('temp'),
        'avatar' => $cloudDisk('avatar'),
        'posts'  => $cloudDisk('posts'),
        'ads'    => $cloudDisk('ads'),

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
