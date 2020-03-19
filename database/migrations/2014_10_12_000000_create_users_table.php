<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')
                ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                ->unique();
            $table->timestampTz('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('deleted_at')->nullable();
            $table->timestampTz('email_verified_at')->nullable();
            $table->text('name');
            $table->text('username')->unique();
            $table->text('email')->unique();
            $table->text('password');
            $table->rememberToken();
        });

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
