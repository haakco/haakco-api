<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class S3Files extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'files.file_types',
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

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.file_types');

        DB::insert(
            "INSERT INTO files.file_types (id, uuid, name)
VALUES (1, '158afec6-964c-4935-8218-92b48d3cd56e', 'Image');"
        );
        DB::insert(
            "INSERT INTO files.file_types (id, uuid, name)
VALUES (2, 'b6539afe-c0d0-4a6b-bdbc-d801b6573da4', 'Document');"
        );
        DB::insert(
            "INSERT INTO files.file_types (id, uuid, name)
VALUES (3, '6d604a2f-0af8-4122-9d82-91e4a5ee4633', 'Video');"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.file_types'
        );


        Schema::create(
            'files.file_storage_types',
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

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.file_types');

        DB::insert(
            "INSERT INTO files.file_storage_types (id, uuid, name)
VALUES (1, 'aa634f5d-2fbf-4e07-bf17-8f91d19e387c', 's3');"
        );
        DB::insert(
            "INSERT INTO files.file_storage_types (id, uuid, name)
VALUES (2, '074d4b60-593c-4e56-9124-a469f4a9b794', 'minio');"
        );
        DB::insert(
            "INSERT INTO files.file_storage_types (id, uuid, name)
VALUES (3, 'c7c93518-3487-47de-b898-dab267fc0edf', 'google');"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'files.file_storage_types'
        );

        Schema::create(
            'files.file_type_tags',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('file_type_id');
                $table->unsignedBigInteger('tag_id');
                $table->foreign('file_type_id')->references('id')->on('files.file_types')->onDelete('cascade');
                $table->foreign('tag_id')->references('id')->on('tags.tags')->onDelete('cascade');
                $table->unique(['file_type_id', 'tag_id']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.file_type_tags');

        Schema::create(
            'files.file_sections',
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
                $table->text('directory')->unique();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.file_sections');


        Schema::create(
            'files.files',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('file_storage_type_id');
                $table->unsignedBigInteger('file_type_id');
                $table->unsignedBigInteger('file_section_id');
                $table->unsignedBigInteger('mime_type_id');
                $table->unsignedBigInteger('extension_id');
                $table->boolean('is_private')->default(true);
                $table->text('name');
                $table->text('url');
                $table->text('original_file_name');
                $table->foreign('file_storage_type_id')->references('id')->on('files.file_storage_types')
                    ->onDelete('cascade');
                $table->foreign('file_type_id')->references('id')->on('files.file_types')
                    ->onDelete('cascade');
                $table->foreign('file_section_id')->references('id')->on('files.file_sections')
                    ->onDelete('cascade');
                $table->foreign('mime_type_id')->references('id')->on('files.mime_types')
                    ->onDelete('cascade');
                $table->foreign('extension_id')->references('id')->on('files.extensions')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.files');

        Schema::create(
            'files.file_extra',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('file_id')->unique();
                $table->jsonb('data_json');
                $table->foreign('file_id')->references('id')->on('files.files')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.file_extra');

        Schema::create(
            'files.file_tags',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('file_id');
                $table->unsignedBigInteger('tag_id');
                $table->foreign('file_id')->references('id')->on('files.files')
                    ->onDelete('cascade');
                $table->foreign('tag_id')->references('id')->on('tags.tags')
                    ->onDelete('cascade');
                $table->unique(['file_id', 'tag_id']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('files.file_tags');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('DROP TABLE IF EXISTS files.file_tags CASCADE');
        DB::delete('DROP TABLE IF EXISTS files.file_extra CASCADE');
        DB::delete('DROP TABLE IF EXISTS files.files CASCADE');
        DB::delete('DROP TABLE IF EXISTS files.file_sections CASCADE');
        DB::delete('DROP TABLE IF EXISTS files.file_type_tags CASCADE');
        DB::delete('DROP TABLE IF EXISTS files.file_types CASCADE');
    }
}
