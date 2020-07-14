<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\EmailGravatar
 *
 * @property-read \App\Models\Email $email
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailGravatar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailGravatar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailGravatar query()
 * @mixin \Eloquent
 */
class EmailGravatar extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'users.email_gravatar';

    protected $casts = [
        'uuid' => 'uuid',
        'exists' => 'boolean',
        'email_id' => 'int'
    ];

    protected $fillable = [
        'exists',
        'email_id',
        'url'
    ];

    public function email()
    {
        return $this->belongsTo(\App\Models\Email::class, 'email_id');
    }
}
