<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\ShortUrlTracking
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property \UuidInterface $uuid
 * @property-read \App\Models\ShortUrl $short_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShortUrlTrackingExtra[] $short_url_tracking_extras
 * @property-read int|null $short_url_tracking_extras_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrlTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrlTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrlTracking query()
 * @mixin \Eloquent
 */
class ShortUrlTracking extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'short_urls.short_url_tracking';

    protected $casts = [
        'uuid' => 'uuid',
        'short_url_id' => 'int',
        'agent_string_id' => 'int',
        'ip' => 'inet',
        'proxy_ip' => 'inet'
    ];

    protected $fillable = [
        'short_url_id',
        'agent_string_id',
        'ip',
        'proxy_ip'
    ];

    public function short_url()
    {
        return $this->belongsTo(\App\Models\ShortUrl::class, 'short_url_id');
    }

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function short_url_tracking_extras()
    {
        return $this->hasMany(\App\Models\ShortUrlTrackingExtra::class, 'short_url_tracking_id');
    }
}
