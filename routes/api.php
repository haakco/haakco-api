<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'middleware' => [
            'api',
            'json.response',
        ],
    ],
    function () {
        Route::get('', 'Api\ApiController@index');
        Route::get('test/basic_system', 'Api\ApiController@testSystem');

        // Just in case something routes to this
        Route::get('login', 'Api\ApiController@index');

        //register
        Route::post('login/register', 'Api\UserController@register');

        // forget password
        Route::post('login/password/forgot', 'Auth\ForgotPasswordController@getResetToken');
        Route::post('login/password/reset', 'Auth\ResetPasswordController@reset');

        Route::get('logout', 'Api\UserController@logout')->name('logout');

        //user verification
        Route::get('login/email/verify/{token}', 'Auth\VerificationController@verify');

        Route::get('rights/permissions', 'Api\RightsController@getPermissions');
        Route::get('rights/roles', 'Api\RightsController@getRoles');
    }
);
