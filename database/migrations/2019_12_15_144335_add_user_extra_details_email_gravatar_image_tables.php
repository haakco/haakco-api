<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserExtraDetailsEmailGravatarImageTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert('CREATE SCHEMA users');

        Schema::create(
            'users.emails',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('email_verified_at')->nullable();
                $table->boolean('checked')->default(false);
                $table->boolean('valid')->default(false);
                $table->text('name')->unique();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.emails');

        Schema::create(
            'users.user_emails',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('deleted_at')->nullable();
                $table->boolean('active')->default(true);
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('email_id');
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('email_id')
                    ->references('id')
                    ->on('users.emails')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.user_emails');

        Schema::create(
            'users.email_gravatar',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->boolean('exists')->default(false);
                $table->unsignedBigInteger('email_id');
                $table->text('url');
                $table->foreign('email_id')
                    ->references('id')
                    ->on('users.emails')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.email_gravatar');

        Schema::create(
            'users.user_image',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('deleted_at')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('file_id');
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('file_id')
                    ->references('id')
                    ->on('files.files')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.user_image');

        DB::insert(
            "insert into files.file_sections
    (name, uuid, directory)
    values
           ('User Images', 'c3dfd153-5d97-4f18-b82f-f4cb53b42eb3', 'user-images')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.file_sections'
        );

        Artisan::queue('email:add');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete("delete from files.file_sections where directory = 'user-images'");
        DB::delete('DROP SCHEMA IF EXISTS users CASCADE');
    }
}
