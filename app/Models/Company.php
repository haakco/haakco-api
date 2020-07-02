<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Company
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompanyRole[] $company_roles
 * @property-read int|null $company_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompanyUser[] $company_users
 * @property-read int|null $company_users_count
 * @property \UuidInterface $uuid
 * @property-read \App\Models\ModelHasRole|null $model_has_role
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company query()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company withoutTrashed()
 * @mixin \Eloquent
 */
class Company extends \App\Models\BaseModel\BaseModel
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

    public function model_has_role()
    {
        return $this->hasOne(\App\Models\ModelHasRole::class, 'company_id');
    }

    public function roles()
    {
        return $this->belongsToMany(\Spatie\Permission\Models\Role::class, 'users.company_roles', 'company_id')
                    ->withPivot('id', 'uuid')
                    ->withTimestamps();
    }

    public function company_roles()
    {
        return $this->hasMany(\App\Models\CompanyRole::class, 'company_id');
    }

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
}
