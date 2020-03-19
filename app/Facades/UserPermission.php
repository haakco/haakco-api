<?php

namespace App\Facades;

use App\Libraries\User\UserPermissionLibrary;
use Illuminate\Support\Facades\Facade;

class UserPermission extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return UserPermissionLibrary::class;
    }
}
