<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\ShortUrl
 *
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShortUrlTracking[] $short_url_trackings
 * @property-read int|null $short_url_trackings_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl query()
 * @mixin \Eloquent
 */
class ShortUrl extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'short_urls.short_urls';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $dates = [
        'dt_deleted'
    ];

    protected $fillable = [
        'dt_deleted',
        'full_url',
        'short_url'
    ];

    public function short_url_trackings()
    {
        return $this->hasMany(\App\Models\ShortUrlTracking::class, 'short_url_id');
    }
}
