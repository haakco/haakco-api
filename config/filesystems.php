<?php

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

        'local-cache' => [
            'driver' => 'local',
            'root' => storage_path('file-cache'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'cache' => [
                'store' => 'file',
//                'driver' => 'adapter',
//                'disk'   => 'local-cache',
//                'file'   => 'flysystem.cache',
                'expire' => env('FILESYSTEM_CLOUD_CACHE_TIME_S3', env('FILESYSTEM_CLOUD_CACHE_TIME', 3600)),
                'prefix' => 'cache-s3',
            ],
        ],

        'minio' => [
            'driver' => 's3',
            'key' => env('MINIO_ACCESS_KEY'),
            'secret' => env('MINIO_SECRET_KEY'),
            'region' => env('MINIO_DEFAULT_REGION', 'us-east-1'),
            'bucket' => env('MINIO_BUCKET'),

            'use_path_style_endpoint' => env('MINIO_USE_PATH_STYLE_ENDPOINT', true),
            'endpoint' => env('MINIO_ENDPOINT', 'http://127.0.0.1:9005'),
            'bucket_endpoint' => false,
            'cache' => [
                'store' => 'file',
//                'driver' => 'adapter',
//                'disk'   => 'local-cache',
//                'file'   => 'flysystem.cache',
                'expire' => env('FILESYSTEM_CLOUD_CACHE_TIME_MINIO', env('FILESYSTEM_CLOUD_CACHE_TIME', 3600)),
                'prefix' => 'cache-minio',
            ],
        ],

        'google' => [
            'driver' => 'google',
            'keyFileLocation' => env('GOOGLE_KEY_FILE_LOCATION'),
            'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
            'teamDriveId' => env('GOOGLE_DRIVE_TEAM_DRIVE_ID'),
            'cache' => [
                'store' => 'file',
//                'driver' => 'adapter',
//                'disk'   => 'local-cache',
//                'file'   => 'flysystem.cache',
                'expire' => env('FILESYSTEM_CLOUD_CACHE_TIME_GOOGLE', env('FILESYSTEM_CLOUD_CACHE_TIME', 3600)),
                'prefix' => 'cache-gdrive',
            ],
        ],

    ],

];
