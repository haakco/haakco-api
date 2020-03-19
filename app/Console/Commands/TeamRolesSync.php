<?php

namespace App\Console\Commands;

use App\Libraries\User\UserRightsLibrary;
use Illuminate\Console\Command;

class TeamRolesSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teamRoles:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs team and user roles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param \App\Libraries\User\UserRightsLibrary $userRightsLibrary
     *
     * @return mixed
     */
    public function handle(UserRightsLibrary $userRightsLibrary)
    {
        $userRightsLibrary->teamRolesSync();
    }
}
