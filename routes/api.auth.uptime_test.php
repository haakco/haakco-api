<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => [
            'api',
            'auth:api',
            'json.response',
        ],
    ],
    function () {
        Route::get('uptime_test_servers', 'Api\UptimeTestController@getUptimeTestServers');

        Route::get('uptime_test_server/{uptime_test_server}', 'Api\UptimeTestController@getUptimeTestServer');

        Route::post('uptime_test_server/create', 'Api\UptimeTestController@createUptimeTestServer');

        Route::put('uptime_test_server/{uptime_test_server}', 'Api\UptimeTestController@updateUptimeTestServer');

        Route::delete('uptime_test_server/{uptime_test_server}', 'Api\UptimeTestController@deleteUptimeTestServer');

        Route::get('uptime_tests', 'Api\UptimeTestController@getUptimeTests');

        Route::get('uptime_test/{uptime_test}', 'Api\UptimeTestController@getUptimeTest');

        Route::post('uptime_test/create', 'Api\UptimeTestController@createUptimeTest');

        Route::get('uptime_test/dial-in/{uptime_test_server_name}', 'Api\UptimeTestController@uptimeTestDialIn');

        Route::delete('uptime_test/{uptime_test}', 'Api\UptimeTestController@deleteUptimeTest');

        Route::get(
            'uptime_test/dialled_in/{uptime_test_server_name}',
            'Api\UptimeTestController@uptimeTestPassesForUptimeTestName'
        );

        Route::get(
            'uptime_test/all_dialled_in',
            'Api\UptimeTestController@uptimeTestPass'
        );
    }
);
