<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\SystemCheck\UptimeTestLibrary;
use App\Models\Enum\Monitoring\UptimeTestEnum;
use App\Models\UptimeTest;
use App\Models\UptimeTestServer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UptimeTestController extends Controller
{
    /**
     * @return UptimeTestServer[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUptimeTestServers()
    {
        return UptimeTestServer::all();
    }

    /**
     * @param UptimeTestServer $uptimeTestServer
     *
     * @return UptimeTestServer
     */
    public function getUptimeTestServer(UptimeTestServer $uptimeTestServer)
    {
        return $uptimeTestServer->load('uptimeTest');
    }

    /**
     * @param Request $request
     *
     * @return UptimeTestServer|\Illuminate\Database\Eloquent\Model
     */
    public function createUptimeTestServer(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:190|unique:tUPTIME_TEST_SERVERS',
                'description' => 'nullable|string|max:190',
                'max_allowed_seconds' => 'nullable|int',
                'active' => 'nullable|int',
            ]
        );
        return UptimeTestServer::create(
            [
                'name' => $request->get('name'),
                'description' => $request->get('description', null),
                'max_allowed_seconds' => $request->get(
                    'max_allowed_seconds',
                    UptimeTestEnum::DEFAULT_MAX_ALLOWED_SECONDS
                ),
                'active' => $request->get('active', UptimeTestEnum::ACTIVE),
            ]
        )->refresh();
    }

    /**
     * @param Request $request
     * @param UptimeTestServer $uptimeTestServer
     *
     * @return UptimeTestServer|JsonResponse
     */
    public function updateUptimeTestServer(Request $request, UptimeTestServer $uptimeTestServer)
    {
        $request->validate(
            [
                'name' => 'string|max:190',
                'description' => 'string|max:190',
                'max_allowed_seconds' => 'int',
                'active' => 'int'
            ]
        );
        $newName = $request->get('name');
        if ($newName) {
            $uptimeTestServerCheck = UptimeTestServer::where('name', $newName)->first();
            /*
             * If a survey with this name exists, it needs to be the survey being updated, or not exist at all
             * This is to stop a duplicate name exception
             */
            if (
                $uptimeTestServerCheck instanceof UptimeTestServer &&
                $uptimeTestServerCheck->id !== $uptimeTestServer->id
            ) {
                return new JsonResponse(
                    ['error' => 'Name already in use'],
                    Response::HTTP_CONFLICT
                );
            }
            $uptimeTestServer->name = $newName;
        }

        $newDescription = $request->get('description');
        if ($newDescription) {
            $uptimeTestServer->description = $newDescription;
        }

        $newSeconds = $request->get('max_allowed_seconds');
        if ($newSeconds) {
            $uptimeTestServer->max_allowed_seconds = $newSeconds;
        }

        $newActive = $request->get('active');
        if ($newActive) {
            $uptimeTestServer->active = $newActive;
        }

        $uptimeTestServer->save();
        return $uptimeTestServer->load('uptimeTest');
    }


    /**
     * @param UptimeTestServer $uptimeTestServer
     *
     * @return UptimeTestServer
     * @throws \Exception
     */
    public function deleteUptimeTestServer(UptimeTestServer $uptimeTestServer)
    {
        $uptimeTestServer->delete();
        return $uptimeTestServer;
    }


    /**
     * @return UptimeTest[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUptimeTests()
    {
        return UptimeTest::all();
    }

    /**
     * @param UptimeTest $uptimeTest
     *
     * @return UptimeTest
     */
    public function getUptimeTest(UptimeTest $uptimeTest)
    {
        return $uptimeTest->load('uptimeTestServer');
    }

    /**
     * @param Request $request
     *
     * @return UptimeTest|\Illuminate\Database\Eloquent\Model
     */
    public function createUptimeTest(Request $request)
    {
        $request->validate(
            [
                'uptime_test_server_id' => 'required|int|exists:tUPTIME_TEST_SERVERS,id',
            ]
        );

        return UptimeTest::create(
            [
                'tUPTIME_TEST_SERVER_id' => $request->get('uptime_test_server_id')
            ]
        );
    }

    /**
     * @param $uptimeTestServerName
     *
     * @return UptimeTest|JsonResponse
     */
    public function uptimeTestDialIn($uptimeTestServerName)
    {
        $uptimeTestServer = UptimeTestServer::where('name', $uptimeTestServerName)->first();
        if (!$uptimeTestServer instanceof UptimeTestServer) {
            return new JsonResponse(
                ['error' => 'Name not found'],
                Response::HTTP_BAD_REQUEST
            );
        }
        if (!$uptimeTestServer->uptimeTest()->exists()) {
            UptimeTest::create(
                [
                    'tUPTIME_TEST_SERVER_id' => $uptimeTestServer->id,
                ]
            );
        }
        $uptimeTestServer->uptimeTest->touch();
        return $uptimeTestServer->uptimeTest->load('uptimeTestServer');
    }

    /**
     * @param UptimeTest $uptimeTest
     *
     * @return UptimeTest
     * @throws \Exception
     */
    public function deleteUptimeTest(UptimeTest $uptimeTest)
    {
        $uptimeTest->delete();
        return $uptimeTest;
    }


    /**
     * @param $uptimeTestName
     *
     * @return JsonResponse
     */
    public function uptimeTestPassesForUptimeTestName($uptimeTestName): JsonResponse
    {
        $uptimeTestServer = UptimeTestServer::where('name', $uptimeTestName)
            ->where('active', UptimeTestEnum::ACTIVE)
            ->first();
        if (!$uptimeTestServer instanceof UptimeTestServer) {
            return new JsonResponse(
                ['error' => 'Name not found'],
                Response::HTTP_PRECONDITION_FAILED
            );
        }
        if (!$this->uptimeTestLibrary()->uptimeTestPasses($uptimeTestServer)) {
            return new JsonResponse(
                ['error' => "Update hasn't happened in time"],
                Response::HTTP_EXPECTATION_FAILED
            );
        }
        return new JsonResponse(
            ['message' => 'Success'],
            Response::HTTP_OK
        );
    }


    /**
     * @return JsonResponse
     */
    public function uptimeTestPass(): JsonResponse
    {
        $uptimeTestServersQuery = UptimeTestServer::where('active', UptimeTestEnum::ACTIVE);
        if ($uptimeTestServersQuery->count() === 0) {
            return new JsonResponse(
                ['message' => 'Success - no active servers'],
                Response::HTTP_OK
            );
        }
        /** @var UptimeTestServer $uptimeTestServer */
        $errorArray = new \stdClass();
        $errorArray->error = [];
        foreach ($uptimeTestServersQuery->get() as $uptimeTestServer) {
            if (!$this->uptimeTestLibrary()->uptimeTestPasses($uptimeTestServer)) {
                $errorArray->error[] = $uptimeTestServer->name . " update hasn't happened in time";
            }
        }
        if (!empty($errorArray->error)) {
            return new JsonResponse(
                $errorArray,
                Response::HTTP_EXPECTATION_FAILED
            );
        }
        return new JsonResponse(
            ['message' => 'Success - all pass'],
            Response::HTTP_OK
        );
    }

    /**
     * @return UptimeTestLibrary
     */
    private function uptimeTestLibrary(): UptimeTestLibrary
    {
        return new UptimeTestLibrary();
    }
}
