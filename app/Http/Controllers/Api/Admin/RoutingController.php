<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Helper\UserRightsLibrary;

class RoutingController extends Controller
{
    public static function possibleRouteList(RoutingLibrary $routingLibrary): array
    {
        return $routingLibrary->possibleRouteList();
    }
}
