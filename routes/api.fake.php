<?php

// Routes need to generate routes but actually go nowhere

Route::group(
    [
        'middleware' => [
            'api',
            'json.response',
        ],
    ],
    function () {
    //reset password
        Route::get('#/password/reset/{email}/{token}', 'Auth\ResetPasswordController@reset')
            ->name('password.reset');
        Route::get('#/login', 'Auth\LoginController@login')
            ->name('login');
    }
);
