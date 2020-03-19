<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::insert('CREATE SCHEMA activitylog');
        Schema::connection(config('activitylog.database_connection'))
            ->create(
                config('activitylog.table_name'),
                function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->timestampTz('created_at')
                        ->default(DB::raw('CURRENT_TIMESTAMP'));
                    $table->timestampTz('updated_at')
                        ->default(DB::raw('CURRENT_TIMESTAMP'));
                    $table->string('log_name')->nullable();
                    $table->text('description');
                    $table->unsignedBigInteger('subject_id')->nullable();
                    $table->string('subject_type')->nullable();
                    $table->unsignedBigInteger('causer_id')->nullable();
                    $table->string('causer_type')->nullable();
                    $table->json('properties')->nullable();

                    $table->index('log_name');
                    $table->index(['subject_id', 'subject_type'], 'subject');
                    $table->index(['causer_id', 'causer_type'], 'causer');
                }
            );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger(config('activitylog.table_name'));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
        DB::delete('DROP SCHEMA IF EXISTS activitylog CASCADE');
    }
}
