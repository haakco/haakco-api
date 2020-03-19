<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\UptimeTestServer
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UptimeTest[] $uptime_tests
 * @property-read int|null $uptime_tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UptimeTestServer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UptimeTestServer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UptimeTestServer query()
 * @mixin \Eloquent
 */
class UptimeTestServer extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'uptime_tests.uptime_test_servers';

    protected $casts = [
        'uuid' => 'uuid',
        'max_allowed_seconds' => 'int',
        'active' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'description',
        'max_allowed_seconds',
        'active'
    ];

    public function uptime_tests()
    {
        return $this->hasMany(\App\Models\UptimeTest::class, 'uptime_test_server_id');
    }
}
