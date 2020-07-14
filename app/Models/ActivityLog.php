<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\ActivityLog
 *
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog query()
 * @mixin \Eloquent
 */
class ActivityLog extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'activitylog.activity_log';

    protected $casts = [
        'subject_id' => 'int',
        'causer_id' => 'int'
    ];

    protected $fillable = [
        'log_name',
        'description',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties'
    ];
}
