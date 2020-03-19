<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'api',
        'auth:api',
        'json.response',
    ],
], function () {

    Route::get('/f/{file}', 'Api\FileController@getPrivateFile')
        ->name('public-file');
});
