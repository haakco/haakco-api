<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\UserEmail
 *
 * @property-read \App\Models\Email $email
 * @property \UuidInterface $uuid
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserEmail newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserEmail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserEmail query()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserEmail withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserEmail withoutTrashed()
 * @mixin \Eloquent
 */
class UserEmail extends \App\Models\BaseModel\BaseModel
{
    use \Illuminate\Database\Eloquent\SoftDeletes;



    protected $table = 'users.user_emails';

    protected $casts = [
        'active' => 'boolean',
        'user_id' => 'int',
        'email_id' => 'int'
    ];

    protected $fillable = [
        'active',
        'user_id',
        'email_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function email()
    {
        return $this->belongsTo(\App\Models\Email::class, 'email_id');
    }
}
