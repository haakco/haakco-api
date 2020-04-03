<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'api',
        'auth:api',
    ],
], function () {
    Route::get('/pf/{file}', 'Api\FileController@getPrivateFile')
        ->name('private-file');
});
