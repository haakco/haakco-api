<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUptimeTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert('CREATE SCHEMA uptime_tests');

        Schema::create('uptime_tests.uptime_test_servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')
                ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                ->unique();
            $table->timestampTz('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('updated_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('name')->unique();
            $table->text('description')->default('');
            $table->unsignedBigInteger('max_allowed_seconds')->default(120);
            $table->boolean('active')->default(true);
        });

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('uptime_tests.uptime_test_servers');

        Schema::create('uptime_tests.uptime_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')
                ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                ->unique();
            $table->timestampTz('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('updated_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('uptime_test_server_id')->unique();
            $table->foreign('uptime_test_server_id')
                ->references('id')
                ->on('uptime_tests.uptime_test_servers')
                ->onDelete('cascade');
        });

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('uptime_tests.uptime_tests');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('DROP SCHEMA IF EXISTS uptime_tests CASCADE');
    }
}
