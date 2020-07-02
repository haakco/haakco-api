<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Email
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmailGravatar[] $email_gravatars
 * @property-read int|null $email_gravatars_count
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserEmail[] $user_emails
 * @property-read int|null $user_emails_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Email query()
 * @mixin \Eloquent
 */
class Email extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'users.emails';

    protected $casts = [
        'uuid' => 'uuid',
        'checked' => 'boolean',
        'valid' => 'boolean'
    ];

    protected $dates = [
        'email_verified_at'
    ];

    protected $fillable = [
        'email_verified_at',
        'checked',
        'valid',
        'name'
    ];

    public function email_gravatars()
    {
        return $this->hasMany(\App\Models\EmailGravatar::class, 'email_id');
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'users.user_emails', 'email_id')
                    ->withPivot('id', 'deleted_at', 'active')
                    ->withTimestamps();
    }

    public function user_emails()
    {
        return $this->hasMany(\App\Models\UserEmail::class, 'email_id');
    }
}
