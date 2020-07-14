<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\UptimeTest
 *
 * @property \UuidInterface $uuid
 * @property-read \App\Models\UptimeTestServer $uptime_test_server
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UptimeTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UptimeTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UptimeTest query()
 * @mixin \Eloquent
 */
class UptimeTest extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'uptime_tests.uptime_tests';

    protected $casts = [
        'uuid' => 'uuid',
        'uptime_test_server_id' => 'int'
    ];

    protected $fillable = [
        'uptime_test_server_id'
    ];

    public function uptime_test_server()
    {
        return $this->belongsTo(\App\Models\UptimeTestServer::class, 'uptime_test_server_id');
    }
}
