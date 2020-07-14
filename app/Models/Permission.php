<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Permission
 *
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RoleHasPermission[] $role_has_permissions
 * @property-read int|null $role_has_permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BasePermissionModel whereFindByName($permissionName)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Permission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Permission withoutTrashed()
 * @mixin \Eloquent
 */
class Permission extends \App\Models\BaseModel\BasePermissionModel
{
    use \Illuminate\Database\Eloquent\SoftDeletes;



    protected $table = 'users.permissions';

    protected $casts = [
        'uuid' => 'uuid',
        'is_system' => 'boolean'
    ];

    protected $fillable = [
        'is_system',
        'name'
    ];

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'users.role_has_permissions', 'permission_id')
                    ->withPivot('id', 'uuid')
                    ->withTimestamps();
    }

    public function role_has_permissions()
    {
        return $this->hasMany(\App\Models\RoleHasPermission::class, 'permission_id');
    }
}
