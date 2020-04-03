<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FileMimeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert('CREATE SCHEMA files');

        Schema::create(
            'files.mime_types',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->text('name')->unique();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.mime_types');

        Schema::create(
            'files.mime_names',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->text('name')->unique();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.mime_names');

        Schema::create(
            'files.mime_type_names',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('mime_type_id');
                $table->unsignedBigInteger('mime_name_id');
                $table->foreign('mime_type_id')
                    ->references('id')
                    ->on('files.mime_types')
                    ->onDelete('cascade');
                $table->foreign('mime_name_id')
                    ->references('id')
                    ->on('files.mime_names')
                    ->onDelete('cascade');
                $table->unique(['mime_type_id', 'mime_name_id']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.mime_types');

        Schema::create(
            'files.extensions',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->text('name')->unique();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.extensions');

        Schema::create(
            'files.mime_type_extensions',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('mime_type_id');
                $table->unsignedBigInteger('extension_id');
                $table->foreign('mime_type_id')
                    ->references('id')
                    ->on('files.mime_types')
                    ->onDelete('cascade');
                $table->foreign('extension_id')
                    ->references('id')
                    ->on('files.extensions')
                    ->onDelete('cascade');
                $table->unique(['mime_type_id', 'extension_id']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.mime_type_extensions');

        Schema::create(
            'files.mime_type_extra',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('mime_type_id');
                $table->jsonb('data_json');
                $table->foreign('mime_type_id')->references('id')->on('files.mime_types')->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.mime_type_extra');

        DB::unprepared(
            file_get_contents(
                app_path() . '/../database/migrations/2019_12_14_090549_file_mime_types_01_mime_types.sql'
            )
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.mime_types'
        );

        DB::unprepared(
            file_get_contents(
                app_path() . '/../database/migrations/2019_12_14_090549_file_mime_types_02_mime_names.sql'
            )
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.mime_names'
        );

        DB::unprepared(
            file_get_contents(
                app_path() . '/../database/migrations/2019_12_14_090549_file_mime_types_03_mime_type_names.sql'
            )
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.mime_type_names'
        );

        DB::unprepared(
            file_get_contents(
                app_path() . '/../database/migrations/2019_12_14_090549_file_mime_types_04_extensions.sql'
            )
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.extensions'
        );

        DB::unprepared(
            file_get_contents(
                app_path() . '/../database/migrations/2019_12_14_090549_file_mime_types_05_mime_type_extensions.sql'
            )
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.mime_type_extensions'
        );

        DB::unprepared(
            file_get_contents(
                app_path() . '/../database/migrations/2019_12_14_090549_file_mime_types_06_mime_type_extra.sql'
            )
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.mime_type_extra'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('DROP SCHEMA IF EXISTS files CASCADE');
    }
}
