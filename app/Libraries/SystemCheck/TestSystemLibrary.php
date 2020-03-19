<?php

namespace App\Libraries\SystemCheck;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis as RedisManager;

class TestSystemLibrary
{
    private const DB_CONNECTION_ERROR_STRING = 'Server DB Problem';
    private const REDIS_CONNECTION_ERROR_STRING = 'Server Redis Problem';

    private function abortAndLog($errStr = ''): bool
    {
        $errStr .= ' on: ' . config('app.env');
        abort(400, $errStr);
        return false;
    }

    public function testAll(): bool
    {
        $result = true;
        try {
            if (!$this->isDatabaseReady()) {
                $result = $this->abortAndLog(self::DB_CONNECTION_ERROR_STRING);
            }
        } catch (\Exception $exception) {
            $result = $this->abortAndLog(self::DB_CONNECTION_ERROR_STRING);
        }
        try {
            if (!$this->isDatabaseReady()) {
                $result = $this->abortAndLog(self::REDIS_CONNECTION_ERROR_STRING);
            }
        } catch (\Exception $exception) {
            $result = $this->abortAndLog(self::REDIS_CONNECTION_ERROR_STRING);
        }
        return $result;
    }

    public function isDatabaseReady($connection = null): bool
    {
        $isReady = true;
        try {
            DB::connection($connection)->getPdo();
        } catch (\Exception $exception) {
            $isReady = false;
        }

        return $isReady;
    }

    public function isRedisReady($connection = null): bool
    {
        $isReady = true;
        try {
            $redis = RedisManager::connection($connection);
            $redis->connect();
            $redis->disconnect();
        } catch (\Exception $exception) {
            $isReady = false;
        }

        return $isReady;
    }
}
