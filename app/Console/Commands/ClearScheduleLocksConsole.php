<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ClearScheduleLocksConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:cache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the schedule locks.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Console start ' . $this->getName());
        $redis = Cache::getRedis();
        $scheduleKeys = $redis->keys('*framework/schedule*');
        foreach ($scheduleKeys as $scheduleKey) {
            Log::info('Deleting schedule key', [
                'keyName' => $scheduleKey,
            ]);
            $redis->del($scheduleKey);
        }
    }
}
