<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\RoleHasPermission
 *
 * @property \UuidInterface $uuid
 * @property-read \App\Models\Permission $permission
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleHasPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleHasPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoleHasPermission query()
 * @mixin \Eloquent
 */
class RoleHasPermission extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'users.role_has_permissions';

    protected $casts = [
        'uuid' => 'uuid',
        'permission_id' => 'int',
        'role_id' => 'int'
    ];

    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    public function permission()
    {
        return $this->belongsTo(\App\Models\Permission::class, 'permission_id');
    }

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }
}
