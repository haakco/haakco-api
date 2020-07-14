<?php

namespace App\Models\BaseModel;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

/**
 * App\Models\BaseModel\BaseRoleModel
 *
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseRoleModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseRoleModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseRoleModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseRoleModel whereFindByName($roleName)
 * @mixin \Eloquent
 */
class BaseRoleModel extends BaseModel
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $roleName
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFindByName(Builder $query, string $roleName): Builder
    {
        return $query->where('name', $roleName);
    }

    /**
     * @param string $roleName
     *
     * @return \App\Models\Role|null
     */
    public static function findByName(string $roleName): ?Role
    {
        return static::whereFindByName($roleName)->first();
    }

    public static function addRole(string $roleName, bool $isDefault = false, bool $isSystem = false): Role
    {
        $role = static::findByName($roleName);
        if (!$role) {
            $role = new Role();
            $role->name = $roleName;
        }

        $role->is_default = $isDefault;
        $role->is_system = $isSystem;
        $role->save();
        return $role;
    }

    /**
     * @param \App\Models\Permission $permission
     *
     * @return Role
     */
    public function assignPermission(Permission $permission): Role
    {
        $this->permissions()->syncWithoutDetaching($permission);
        $this->refresh();
        return $this;
    }

    public function assignPermissionByName(string $permissionName): Role
    {
        $permission = Permission::findByName($permissionName);
        if (!$permission) {
            throw PermissionDoesNotExist::named($permissionName);
        }

        $this->assignPermission($permission);
        return $this;
    }

    public function removePermission(Permission $permission): Role
    {
        $this->permissions()->detach($permission);
        return $this;
    }

    public function removePermissionByName(string $permissionName): Role
    {
        $permission = Permission::findByName($permissionName);
        if ($permission) {
            $this->removePermission($permission);
        }
        return $this;
    }
}
