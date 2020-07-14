<?php

namespace App\Models\Enum\Rights;

class RightsEnum
{

    public const SYSTEM_ROLE_SUPER_ADMIN = 'System Super Admin';

    //All system users must have this role
    public const SYSTEM_ROLE_USER = 'System User';

    public const SYSTEM_ROLE_ARRAY = [
        self::SYSTEM_ROLE_SUPER_ADMIN,
        self::SYSTEM_ROLE_USER,
    ];

    public const SYSTEM_PERMISSION_IS_SYSTEM_USER = 'System User';
    public const SYSTEM_PERMISSION_DEVELOPER_TOOLS = 'System Developer Tools';
    public const SYSTEM_PERMISSION_USERS_VIEW = 'System Users View';
    public const SYSTEM_PERMISSION_USERS_EDIT = 'System Users Edit';
    public const SYSTEM_PERMISSION_USERS_RIGHTS_EDIT = 'System Users Rights Edit';

    public const SYSTEM_PERMISSION_ARRAY = [
        self::SYSTEM_PERMISSION_IS_SYSTEM_USER,
        self::SYSTEM_PERMISSION_DEVELOPER_TOOLS,
        self::SYSTEM_PERMISSION_USERS_VIEW,
        self::SYSTEM_PERMISSION_USERS_EDIT,
        self::SYSTEM_PERMISSION_USERS_RIGHTS_EDIT,
    ];

    //Default roles
    public const CLIENT_ROLE_OWNER = 'Owner';

    //All system users must have this role
    public const CLIENT_ROLE_USER = 'User';

    public const CLIENT_ROLE_ARRAY = [
        self::CLIENT_ROLE_OWNER,
        self::CLIENT_ROLE_USER,
    ];

    public const CLIENT_PERMISSION_USERS_VIEW = 'Client Users View';
    public const CLIENT_PERMISSION_USERS_EDIT = 'Client Users Edit';
    public const CLIENT_PERMISSION_USERS_RIGHTS_EDIT = 'Client Users Rights Edit';

    public const CLIENT_PERMISSION_ARRAY = [
        self::CLIENT_PERMISSION_USERS_VIEW,
        self::CLIENT_PERMISSION_USERS_EDIT,
        self::CLIENT_PERMISSION_USERS_RIGHTS_EDIT,
    ];
}
