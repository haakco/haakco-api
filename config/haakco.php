<?php

return [
    'company_name' => env('HAAK_COMPANY_NAME', 'haakco'),
    'company_id' => 0,
    'create_company_for_each_user' => env('HAAK_CREATE_COMPANY_FOR_EACH_USER', false),
    'short_url' => env('HAAK_SHORT_URL', 'https://example.com'),
    'primary_user' => [
        'name' => env('HAAK_ADMIN_USER', 'Admin User'),
        'username' => env('HAAK_ADMIN_USERNAME', 'adminuser'),
        'email' => env('HAAK_ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('HAAK_ADMIN_PASSWORD', \Illuminate\Support\Str::random(20)),
    ],
    'server_admin_email' => [
        env('HAAK_SERVER_ADMIN_EMAIL_NAME', 'Server Admin') =>
            env('HAAK_SERVER_ADMIN_EMAIL', 'serveradmin@example.com'),
    ],

    'rights_tables' => [
        'roles' => 'users.roles',
        'permissions' => 'users.permissions',
    ],
    'api_path' => 'api/v1',
    'registration_enabled' => env('HAAK_REGISTRATION_ENABLED', true),

    'cache_short_seconds' => env('CACHE_SHORT_SECONDS', '300'),
    'access_token_lifetime_days' => env('ACCESS_TOKEN_LIFETIME_DAYS', 15),
    'refresh_token_lifetime_days' => env('REFRESH_TOKEN_LIFETIME_DAYS', 30),
    'personal_access_token_lifetime_days' => env('PERSONAL_ACCESS_TOKEN_LIFETIME_DAYS', 200),

    'slack_app_id' => env('SLACK_APP_ID'),
    'slack_client_id' => env('SLACK_CLIENT_ID'),
    'slack_secret' => env('SLACK_SECRET'),
    'slack_signing_secret' => env('SLACK_SIGNING_SECRET'),
    'slack_oauth_access_token' => env('SLACK_OAUTH_ACCESS_TOKEN'),
    'slack_redirect_uri' => env('SLACK_REDIRECT_URI'),
    'slack_token' => env('SLACK_TOKEN'),
    'slack_bot_username' => env('SLACK_BOT_USERNAME'),
    'slack_hook_general' => env('SLACK_HOOK_GENERAL'),
];
