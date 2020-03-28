<?php

use \App\Models\Enum\DatabaseEnum;
use Illuminate\Database\Migrations\Migration;

class AddUpdateTimestampFunction extends Migration
{

    public function up()
    {
        //Only run this when we are using postgresql
        if (env('DB_CONNECTION') === DatabaseEnum::DB_POSTGRESQL) {
            \App\Libraries\Helper\DatabaseLibrary::createPgsqlUpdatedAtFunction();
        }
    }

    public function down()
    {
        //Only run this when we are using postgresql
        if (env('DB_CONNECTION') === DatabaseEnum::DB_POSTGRESQL) {
            \App\Libraries\Helper\DatabaseLibrary::removePgsqlUpdatedAtFunction();
        }
    }
}
