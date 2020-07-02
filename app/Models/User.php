<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\User
 *
 * @property int $id
 * @property \UuidInterface $uuid
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthClient[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Company[] $companies
 * @property-read int|null $companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompanyUser[] $company_users
 * @property-read int|null $company_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Email[] $emails
 * @property-read int|null $emails_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserEmail[] $user_emails
 * @property-read int|null $user_emails_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserImage[] $user_images
 * @property-read int|null $user_images_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends \App\Models\BaseModel\BaseUserModel
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Ryancco\HasUuidRouteKey\HasUuidRouteKey;



    protected $table = 'public.users';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $dates = [
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'email_verified_at',
        'name',
        'username',
        'email',
        'password',
        'remember_token'
    ];

    public function user_images()
    {
        return $this->hasMany(\App\Models\UserImage::class, 'user_id');
    }

    public function emails()
    {
        return $this->belongsToMany(\App\Models\Email::class, 'users.user_emails', 'user_id')
                    ->withPivot('id', 'deleted_at', 'active')
                    ->withTimestamps();
    }

    public function user_emails()
    {
        return $this->hasMany(\App\Models\UserEmail::class, 'user_id');
    }

    public function companies()
    {
        return $this->belongsToMany(\App\Models\Company::class, 'users.company_users', 'user_id')
                    ->withPivot('id', 'uuid', 'deleted_at', 'is_owner')
                    ->withTimestamps();
    }

    public function company_users()
    {
        return $this->hasMany(\App\Models\CompanyUser::class, 'user_id');
    }
}
