<?php

namespace App\Libraries\User;

use App\Models\Company;
use App\Models\Enum\Rights\RightsEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UserRightsLibrary
{
    public function updateAll(): void
    {
        $this->updateRoles();
        $this->updatePermissions();
    }

    public function updateRoles(): void
    {
        $isSystem = true;
        $isDefault = true;
        foreach (RightsEnum::SYSTEM_ROLE_ARRAY as $roleName) {
            Role::addRole($roleName, $isSystem, $isDefault);
        }

        $isNotSystem = false;
        foreach (RightsEnum::CLIENT_ROLE_ARRAY as $roleName) {
            Role::addRole($roleName, $isSystem, $isNotSystem);
        }
    }

    public function updatePermissions(): void
    {
        $superAdminRole = Role::findByName(RightsEnum::SYSTEM_ROLE_SUPER_ADMIN);

        $isSystem = true;
        foreach (RightsEnum::SYSTEM_PERMISSION_ARRAY as $permissionName) {
            $permission = Permission::addPermission($permissionName, $isSystem);
            $superAdminRole->assignPermission($permission);
        }

        $clientOwnerRole = Role::findByName(RightsEnum::CLIENT_ROLE_OWNER);
        $isNotSystem = false;
        foreach (RightsEnum::CLIENT_PERMISSION_ARRAY as $permissionName) {
            $permission = Permission::addPermission($permissionName, $isNotSystem);
            $clientOwnerRole->assignPermission($permission);
            $superAdminRole->assignPermission($permission);
        }
    }

    public function getAllPermissions($getTypeScriptEnum = false)
    {
        $permissionsQuery = Permission::query();
        $permissions = $permissionsQuery
            ->get()
            ->pluck('name', 'uuid');
        if (!$getTypeScriptEnum) {
            return $permissions;
        }
        return view(
            'enums.typeScriptEnum',
            [
                'enumName' => 'Permission',
                'dataArray' => $permissions,
            ]
        );
    }

    public function getAllSystemRoles($getTypeScriptEnum = false)
    {
        $roles = Role::query()
            ->where('is_default', true)
            ->get()
            ->pluck('name', 'uuid');
        if (!$getTypeScriptEnum) {
            return $roles;
        }
        return view(
            'enums.typeScriptEnum',
            [
                'enumName' => 'Role',
                'dataArray' => $roles,
            ]
        );
    }
}
