<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'api',
        'auth:api',
        'json.response',
    ],
], function () {

    Route::get('rights/permissions', 'Api\RightsController@getPermissions');
    Route::get('rights/roles', 'Api\RightsController@getRoles');
});
