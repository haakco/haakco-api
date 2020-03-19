<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\ShortUrlTrackingExtra
 *
 * @property mixed $data_json
 * @property-read \App\Models\ShortUrlTracking $short_url_tracking
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrlTrackingExtra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrlTrackingExtra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrlTrackingExtra query()
 * @mixin \Eloquent
 */
class ShortUrlTrackingExtra extends \App\Models\BaseModel\BaseModel
{
    use \App\Models\ModelTraits\DataJsonTrait;



    protected $table = 'short_urls.short_url_tracking_extra';

    protected $casts = [
        'uuid' => 'uuid',
        'short_url_tracking_id' => 'int',
        'data_json' => 'text'
    ];

    protected $fillable = [
        'short_url_tracking_id',
        'data_json'
    ];

    public function short_url_tracking()
    {
        return $this->belongsTo(\App\Models\ShortUrlTracking::class, 'short_url_tracking_id');
    }
}
