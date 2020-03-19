<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthPersonalAccessClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_personal_access_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->timestampTz('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('updated_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('client_id')->index();
        });

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('oauth_personal_access_clients');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_personal_access_clients');
    }
}
