<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\SystemCheck\TestSystemLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json(['msg' => 'Api']);
    }

    /**
     * @param TestSystemLibrary $testSystemLibrary
     * @return JsonResponse
     */
    public function testSystem(TestSystemLibrary $testSystemLibrary): JsonResponse
    {
        return response()->json([
            'systemWorking' => $testSystemLibrary->testAll(),
        ]);
    }
}
