<?php

namespace App\Libraries\Helper;

use Illuminate\Support\Collection;

class SessionHeaderLibrary
{
    public const SESSION_HEADER_UNSAFE_ARRAY = [
        'AWS_ACCESS_KEY_ID',
        'AWS_BUCKET',
        'AWS_SECRET_ACCESS_KEY',
        'APP_DEBUG',
        'APP_KEY',
        'BROADCAST_DRIVER',
        'CACHE_DRIVER',
        'DB_CONNECTION',
        'DB_DATABASE',
        'DB_HOST',
        'DB_PASSWORD',
        'DB_PORT',
        'DB_USERNAME',
        'GOOGLE_ANALYTICS_TRACKING_ID',
        'HTTP_COOKIE',
        'MAIL_HOST',
        'MAIL_ENCRYPTION',
        'MAIL_DRIVER',
        'MAIL_PASSWORD',
        'MAIL_PORT',
        'MAIL_USERNAME',
        'PUSHER_APP_ID',
        'PUSHER_APP_KEY',
        'PUSHER_APP_SECRET',
        'QUEUE_DRIVER',
        'REDIS_HOST',
        'REDIS_PASSWORD',
        'REDIS_PORT',
        'SESSION_DRIVER',
        'SENDGRID_API_KEY',
    ];

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSafeSessionHeaders(): \Illuminate\Support\Collection
    {
        return $this->filterHeaders(collect($_SERVER));
    }

    /**
     * @param Collection $headers
     *
     * @return \Illuminate\Support\Collection
     */
    public function filterHeaders(Collection $headers): \Illuminate\Support\Collection
    {
        return $headers->filter(function ($value, $key) {
            return !in_array($key, self::SESSION_HEADER_UNSAFE_ARRAY, true);
        });
    }
}
