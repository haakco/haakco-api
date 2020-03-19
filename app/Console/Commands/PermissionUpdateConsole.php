<?php

namespace App\Console\Commands;

use App\Libraries\User\UserRightsLibrary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PermissionUpdateConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates available permissions and roles';

    /**
     * Execute the console command.
     *
     * @param UserRightsLibrary $permissionLibrary
     * @return mixed
     */
    public function handle(UserRightsLibrary $permissionLibrary)
    {
        Log::info('Console start ' . $this->getName());

        $permissionLibrary->updateAll();
    }
}
