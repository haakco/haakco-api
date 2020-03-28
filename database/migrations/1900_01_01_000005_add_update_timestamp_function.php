<?php

use Illuminate\Database\Migrations\Migration;

class AddUpdateTimestampFunction extends Migration
{

    public function up()
    {
            \App\Libraries\Helper\DatabaseLibrary::createPgsqlUpdatedAtFunction();
    }

    public function down()
    {
            \App\Libraries\Helper\DatabaseLibrary::removePgsqlUpdatedAtFunction();
    }
}
