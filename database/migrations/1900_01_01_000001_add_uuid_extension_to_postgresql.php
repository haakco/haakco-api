<?php

use \App\Models\Enum\DatabaseEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddUuidExtensionToPostgresql extends Migration
{

    public function up()
    {
        //Only run this when we are using postgresql
        if (env('DB_CONNECTION') === DatabaseEnum::DB_POSTGRESQL) {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        }
    }

    public function down()
    {
        //Only run this when we are using postgresql
        if (env('DB_CONNECTION') === DatabaseEnum::DB_POSTGRESQL) {
            DB::statement('DROP EXTENSION IF EXISTS "uuid-ossp";');
        }
    }
}
