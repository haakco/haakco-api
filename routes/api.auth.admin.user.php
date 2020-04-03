<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'api',
//        'auth:api',
        'json.response',
    ],
], function () {
    Route::get('/admin/possible_route_list', 'Api\Admin\RoutingController@possibleRouteList');
});
