<?php

namespace App\Models\Enum;

class PermissionsEnum
{
    public const SYSTEM_USER_ID = 1;
    public const SYSTEM_USER_NAME = 'System User';
    public const SYSTEM_DEVELOPER_TOOLS_ID = 2;
    public const SYSTEM_DEVELOPER_TOOLS_NAME = 'System Developer Tools';
    public const SYSTEM_USERS_VIEW_ID = 3;
    public const SYSTEM_USERS_VIEW_NAME = 'System Users View';
    public const SYSTEM_USERS_EDIT_ID = 4;
    public const SYSTEM_USERS_EDIT_NAME = 'System Users Edit';
    public const SYSTEM_USERS_RIGHTS_EDIT_ID = 5;
    public const SYSTEM_USERS_RIGHTS_EDIT_NAME = 'System Users Rights Edit';
    public const CLIENT_USERS_VIEW_ID = 6;
    public const CLIENT_USERS_VIEW_NAME = 'Client Users View';
    public const CLIENT_USERS_EDIT_ID = 7;
    public const CLIENT_USERS_EDIT_NAME = 'Client Users Edit';
    public const CLIENT_USERS_RIGHTS_EDIT_ID = 8;
    public const CLIENT_USERS_RIGHTS_EDIT_NAME = 'Client Users Rights Edit';
}
