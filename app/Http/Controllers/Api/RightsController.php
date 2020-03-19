<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\User\UserRightsLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RightsController extends Controller
{
    public function getPermissions(Request $request, UserRightsLibrary $permissionLibrary)
    {
        $request->validate(
            [
                'typescript_enum' => 'boolean',
            ]
        );

        $getTypeScriptEnum = $request->get('typescript_enum', false);
        return $permissionLibrary->getAllPermissions($getTypeScriptEnum);
    }

    public function getRoles(Request $request, UserRightsLibrary $permissionLibrary)
    {
        $request->validate(
            [
                'typescript_enum' => 'boolean',
            ]
        );

        $getTypeScriptEnum = $request->get('typescript_enum', false);

        return $permissionLibrary->getAllSystemRoles($getTypeScriptEnum);
    }
}
