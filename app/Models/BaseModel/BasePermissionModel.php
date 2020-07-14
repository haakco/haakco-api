<?php

namespace App\Models\BaseModel;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\BaseModel\BasePermissionModel
 *
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BasePermissionModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BasePermissionModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BasePermissionModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BasePermissionModel whereFindByName($permissionName)
 * @mixin \Eloquent
 */
class BasePermissionModel extends BaseModel
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $permissionName
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFindByName(Builder $query, string $permissionName): Builder
    {
        return $query->where('name', $permissionName);
    }

    /**
     * @param $permissionName
     *
     * @return \App\Models\Permission|null
     */
    public static function findByName(string $permissionName): ?Permission
    {
        return static::whereFindByName($permissionName)->first();
    }

    public static function addPermission(string $permissionName, bool $isSystem = false): Permission
    {
        $permission = static::findByName($permissionName);
        if (!$permission) {
            $role = new Role();
            $role->name = $permissionName;
        }

        if (!$permission) {
            $permission = new Permission();
            $permission->name = $permissionName;
        }
        $permission->is_system = $isSystem;
        $permission->save();
        return $permission;
    }
}
