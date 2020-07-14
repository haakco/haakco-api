<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Role
 *
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RoleHasPermission[] $role_has_permissions
 * @property-read int|null $role_has_permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserHasRole[] $user_has_roles
 * @property-read int|null $user_has_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseRoleModel whereFindByName($roleName)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role withoutTrashed()
 * @mixin \Eloquent
 */
class Role extends \App\Models\BaseModel\BaseRoleModel
{
    use \Illuminate\Database\Eloquent\SoftDeletes;



    protected $table = 'users.roles';

    protected $casts = [
        'uuid' => 'uuid',
        'is_system' => 'boolean',
        'is_default' => 'boolean'
    ];

    protected $fillable = [
        'is_system',
        'is_default',
        'name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'users.role_has_permissions', 'role_id')
                    ->withPivot('id', 'uuid')
                    ->withTimestamps();
    }

    public function role_has_permissions()
    {
        return $this->hasMany(\App\Models\RoleHasPermission::class, 'role_id');
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'users.user_has_roles', 'role_id')
                    ->withPivot('id', 'uuid', 'company_id')
                    ->withTimestamps();
    }

    public function user_has_roles()
    {
        return $this->hasMany(\App\Models\UserHasRole::class, 'role_id');
    }
}
