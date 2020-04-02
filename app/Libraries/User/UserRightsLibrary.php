<?php

namespace App\Libraries\User;

use App\Models\Company;
use App\Models\CompanyRole;
use App\Models\Enum\Rights\RightsEnum;
use App\Models\ModelHasRole;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRightsLibrary
{

    public function __construct()
    {
    }

    public function updateAll(): void
    {
        $this->updateRoles();
        $this->updatePermissions();
    }

    public function updateRoles(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        foreach (RightsEnum::DEFAULT_SYSTEM_ROLE_ARRAY as $roleName) {
            $role = Role::findOrCreate($roleName);
            if (!$role->is_system) {
                $role->is_system = true;
                $role->is_default = true;
                $role->save();
            }
        }

        foreach (RightsEnum::DEFAULT_CLIENT_ROLE_ARRAY as $roleName) {
            $role = Role::findOrCreate($roleName);
            $role->is_system = false;
            $role->is_default = true;
            $role->save();
        }

        app()['cache']->forget('spatie.permission.cache');
    }

    public function updatePermissions(): void
    {
        app()['cache']->forget('spatie.permission.cache');
        $superAdminRole = Role::findByName(RightsEnum::SYSTEM_ROLE_SUPER_ADMIN);

        foreach (RightsEnum::SYSTEM_PERMISSION_ARRAY as $permission) {
            $permission = Permission::findOrCreate($permission);
            if (!$permission->is_system) {
                $permission->is_system = true;
                $permission->save();
            }
            $superAdminRole->givePermissionTo($permission);
        }

        $clientOwnerRole = Role::findByName(RightsEnum::CLIENT_ROLE_OWNER);
        foreach (RightsEnum::CLIENT_PERMISSION_ARRAY as $permission) {
            $permission = Permission::findOrCreate($permission);
            $clientOwnerRole->givePermissionTo($permission);
        }

        app()['cache']->forget('spatie.permission.cache');
    }

    /**
     * @param \App\Models\Company $company
     * @param array $deleteRoles
     *
     * @throws \Exception
     */
    public function deleteRole(Company $company, $deleteRoles = []): void
    {
        if (count($deleteRoles) > 0) {
            foreach ($deleteRoles as $deleteRoleName) {
                $role = Role::findOrCreate($deleteRoleName);

                if (!$role->is_system && !$role->is_default) {
                    ModelHasRole::query()
                        ->where('company_id', $company->id)
                        ->where('role_id', $role->id)
                        ->delete();

                    CompanyRole::query()
                        ->where('role_id', $role->id)
                        ->where('company_id', $company->id)
                        ->delete();
                }
            }
        }
        app()['cache']->forget('spatie.permission.cache');
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

    public function teamRolesSync() {

    }
}
