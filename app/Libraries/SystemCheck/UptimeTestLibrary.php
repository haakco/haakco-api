<?php

namespace App\Libraries\SystemCheck;

use App\Models\UptimeTestServer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UptimeTestLibrary
{
    /**
     * @param UptimeTestServer $uptimeTestServer
     * @return bool
     */
    public function uptimeTestPasses(UptimeTestServer $uptimeTestServer): bool
    {
        if (!$uptimeTestServer->uptime_tests()->exists()) {
            $this->logFailureNoTestsRan($uptimeTestServer);
            return false;
        }
        $sql = 'SELECT
        extract(EPOCH FROM (ut.updated_at::TIMESTAMP - now()::TIMESTAMP)) >
        uts.max_allowed_seconds AS fail
  ,     extract(EPOCH FROM (ut.updated_at::TIMESTAMP - now()::TIMESTAMP))   AS secondsSinceUpdate
  ,     uts.max_allowed_seconds
FROM
    uptime_tests.uptime_tests ut
        JOIN uptime_tests.uptime_test_servers uts
             ON ut.uptime_test_server_id = uts.id
WHERE
    ut.id = :uptime_test_id;';
        $result = DB::selectOne($sql, [
            'uptime_test_id' => $uptimeTestServer->uptimeTest->id,
        ]);
        if ($result->fail === 1) {
            $this->logFailure($uptimeTestServer, $result->secondsSinceUpdate);
            return false;
        }
        $this->logSuccess($uptimeTestServer, $result->secondsSinceUpdate);
        return true;
    }

    /**
     * @param UptimeTestServer $uptimeTestServer
     * @param $secondsSinceUpdate
     */
    public function logFailure(UptimeTestServer $uptimeTestServer, $secondsSinceUpdate): void
    {
        Log::error("Cron update hasn't happened in scheduled time", [
            'Server: ' . $uptimeTestServer->name,
            'seconds since update' . $secondsSinceUpdate
        ]);
    }


    /**
     * @param UptimeTestServer $uptimeTestServer
     */
    public function logFailureNoTestsRan(UptimeTestServer $uptimeTestServer): void
    {
        Log::error('Cron update has not ran yet, no test logged', [
            'Server: ' . $uptimeTestServer->name
        ]);
    }

    /**
     * @param UptimeTestServer $uptimeTestServer
     * @param $secondsSinceUpdate
     */
    public function logSuccess(UptimeTestServer $uptimeTestServer, $secondsSinceUpdate): void
    {
        Log::info('Cron update has happened in scheduled time', [
            'Server: ' . $uptimeTestServer->name,
            'seconds since update' . $secondsSinceUpdate
        ]);
    }
}
