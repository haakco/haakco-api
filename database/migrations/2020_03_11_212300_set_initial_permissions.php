<?php

use App\Libraries\User\UserLibrary;
use App\Libraries\User\UserRightsLibrary;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

class SetInitialPermissions extends Migration
{
    /**
     * Run the migrations.
     * @return void
     * @throws \Exception
     */
    public function up(): void
    {
        $permissionLibrary = new UserRightsLibrary();
        $permissionLibrary->updateAll();

        $userLibrary = new UserLibrary();
        $userLibrary->createPrimarySystemUser();

        $permissionLibrary->updateAll();
    }

    /**
     * Reverse the migrations.
     * @return void
     * @throws \Exception
     */
    public function down()
    {
        Role::query()
            ->delete();
        Permission::query()
            ->delete();
        User::query()
            ->delete();
    }
}
