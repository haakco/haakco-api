<?php

namespace App\Libraries\User;

use App\Models\Enum\PermissionsEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPermissionLibrary
{
    /**
     * @param array $permissions
     * @param \App\Models\User|null $user
     *
     * @return bool
     * @throws \Exception
     */
    public function testIfUserHasAnyPermission($permissions = [], ?User $user = null): bool
    {
        if ($user === null) {
            $user = Auth::user();
        }
        return $user instanceof User &&
            $user->hasAnyPermissionByName($permissions);
    }

    /**
     * @param \App\Models\User $checkUser
     * @param array $permissions
     * @param \App\Models\User|null $user
     *
     * @return bool
     * @throws \Exception
     */
    public function testIfIsUserOrHasUserAnyPermission(User $checkUser, $permissions = [], ?User $user = null): bool
    {
        if ($user === null) {
            $user = Auth::user();
        }
        if ($checkUser === $user) {
            return true;
        }
        return $this->testIfUserHasAnyPermission($permissions, $user);
    }

    /**
     * @param \App\Models\User|null $user
     *
     * @return bool
     * @throws \Exception
     */
    public function testIfIsSystemUser(?User $user = null): bool
    {
        if ($user === null) {
            $user = Auth::user();
        }
        return $user instanceof User &&
            $user->hasAnyPermissionByName([PermissionsEnum::SYSTEM_USER_NAME]);
    }

    /**
     * @param array $permissions
     * @param \App\Models\User|null $user
     *
     * @return bool
     * @throws \Exception
     */
    public function allowIfUserHasAnyPermission($permissions = [], ?User $user = null): bool
    {
        if (!$this->testIfUserHasAnyPermission($permissions, $user)) {
            abort(403, 'Unauthorized action. Missing permission: ' . implode(',', $permissions));
            return false;
        }
        return true;
    }

    /**
     * @param \App\Models\User $checkUser
     * @param array $permissions
     * @param \App\Models\User|null $user
     *
     * @return bool
     * @throws \Exception
     */
    public function allowIfIsUserOrUserHasAnyPermission(User $checkUser, $permissions = [], ?User $user = null): bool
    {
        if (!$this->testIfIsUserOrHasUserAnyPermission($checkUser, $permissions, $user)) {
            abort(403, 'Unauthorized action');
            return false;
        }
        return true;
    }
}
