<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'api',
        'auth:api',
        'json.response',
    ],
], function () {

    Route::get('/me', 'Api\UserController@getMyUser');
    Route::get('/me/permissions', 'Api\UserController@getMyPermissions');
    Route::get('/me/companies', 'Api\UserController@getMyCompanies');

    Route::get('/user/{user}/permissions', 'Api\UserController@getMyPermissions');
    Route::post('/user/{user}/image', 'Api\UserController@addUserImage');

    Route::post('/user/{user}/password', 'Api\UserController@updateUserPassword');

    Route::get('/user/{user}', 'Api\UserController@getUser');

    Route::post('/user/{user}', 'Api\UserController@updateUser');

    Route::get('/users', 'Api\UserController@users');
});
