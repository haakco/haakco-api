<?php

use Illuminate\Database\Migrations\Migration;

class AddUpdateTimestampFunction extends Migration
{

    public function up()
    {
        \App\Libraries\Helper\DatabaseLibrary::createUpdatedAtFunction();
    }

    public function down()
    {
        \App\Libraries\Helper\DatabaseLibrary::removeUpdatedAtFunction();
    }
}
