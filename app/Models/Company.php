<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Company
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompanyUser[] $company_users
 * @property-read int|null $company_users_count
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserHasRole[] $user_has_roles
 * @property-read int|null $user_has_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BasePermissionModel whereFindByName($permissionName)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company withoutTrashed()
 * @mixin \Eloquent
 */
class Company extends \App\Models\BaseModel\BasePermissionModel
{
    use \Illuminate\Database\Eloquent\SoftDeletes;



    protected $table = 'users.companies';

    protected $casts = [
        'uuid' => 'uuid',
        'is_system' => 'boolean'
    ];

    protected $fillable = [
        'is_system',
        'name',
        'slug'
    ];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'users.company_users', 'company_id')
                    ->withPivot('id', 'uuid', 'deleted_at', 'is_owner')
                    ->withTimestamps();
    }

    public function company_users()
    {
        return $this->hasMany(\App\Models\CompanyUser::class, 'company_id');
    }

    public function user_has_roles()
    {
        return $this->hasMany(\App\Models\UserHasRole::class, 'company_id');
    }
}
