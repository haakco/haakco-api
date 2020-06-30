<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentStringTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert('CREATE SCHEMA agent_strings');

        Schema::create(
            'agent_strings.agent_strings',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->boolean('parsed')->default(false);
                $table->text('name')->unique();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_strings');

        Schema::create(
            'agent_strings.agent_string_operating_system_types',
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

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_operating_system_types');

        DB::insert(
            "INSERT INTO agent_strings.agent_string_operating_system_types(id, uuid, name)
values (0, '237e03db-72f4-47dc-bb2b-2e60e6ef744f', 'Unknown')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert('agent_strings.agent_string_operating_system_types');

        Schema::create(
            'agent_strings.agent_string_operating_system_version_types',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_operating_system_type_id');
                $table->text('name')->unique();
                $table->foreign('agent_string_operating_system_type_id')
                    ->references('id')
                    ->on('agent_strings.agent_string_operating_system_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger(
            'agent_strings.agent_string_operating_system_version_types'
        );


        DB::insert(
            "insert into agent_strings.agent_string_operating_system_version_types
    (id, uuid, agent_string_operating_system_type_id, name)
values (0, '990b671b-9591-4c11-ac2b-797578206c81', 0, 'Unknown')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'agent_strings.agent_string_operating_system_version_types'
        );

        Schema::create(
            'agent_strings.agent_string_operating_systems',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id')->unique();
                $table->unsignedBigInteger('agent_string_operating_system_type_id');
                $table->unsignedBigInteger('agent_string_operating_system_version_type_id');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
                $table->foreign('agent_string_operating_system_type_id')
                    ->references('id')
                    ->on('agent_strings.agent_string_operating_system_types')
                    ->onDelete('cascade');
                $table->foreign(
                    'agent_string_operating_system_version_type_id',
                    'agent_string_operating_systems_agent_string_operating_system_version_type_id_foreign'
                )
                    ->references('id')
                    ->on('agent_strings.agent_string_operating_system_version_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_operating_systems');


        Schema::create(
            'agent_strings.agent_string_device_manufacturer_types',
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

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_manufacturer_types');


        DB::insert(
            "insert into agent_strings.agent_string_device_manufacturer_types
    (id, uuid, name)
values (0, 'af6f7708-378a-4362-9b38-625ff4b6f917', 'Unknown')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'agent_strings.agent_string_device_manufacturer_types'
        );

        Schema::create(
            'agent_strings.agent_string_device_manufacturers',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id');
                $table->unsignedBigInteger('agent_string_device_manufacturer_type_id');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
                $table->foreign('agent_string_device_manufacturer_type_id')
                    ->references('id')
                    ->on('agent_strings.agent_string_device_manufacturer_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_manufacturers');

        Schema::create(
            'agent_strings.agent_string_device_model_types',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->text('name');
                $table->text('identifier')->default('');
                $table->text('version')->default('');
                $table->text('url')->default('');
                $table->unique(['name', 'identifier', 'version']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_model_types');


        DB::insert(
            "insert into agent_strings.agent_string_device_model_types
    (id, uuid, name)
    values (0, 'c59b7fb6-04e5-477c-8170-f8c740025946', 'Unknown')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert('agent_strings.agent_string_device_model_types');

        Schema::create(
            'agent_strings.agent_string_device_models',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id')->unique();
                $table->unsignedBigInteger('agent_string_device_model_type_id');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
                $table->foreign('agent_string_device_model_type_id')
                    ->references('id')
                    ->on('agent_strings.agent_string_device_model_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_models');

        Schema::create(
            'agent_strings.agent_string_device_types',
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

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_types');

        DB::insert(
            "insert into
    agent_strings.agent_string_device_types
    (id, uuid, name)
    values (0, 'b1fad10d-df40-4da7-b18f-7eeec2240caa', 'Unknown')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert('agent_strings.agent_string_device_types');

        Schema::create(
            'agent_strings.agent_string_devices',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id')->unique();
                $table->unsignedBigInteger('agent_string_device_type_id');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
                $table->foreign('agent_string_device_type_id')
                    ->references('id')
                    ->on('agent_strings.agent_string_device_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_devices');

        Schema::create(
            'agent_strings.agent_string_device_sub_types',
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

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_sub_types');

        DB::insert(
            "insert into agent_strings.agent_string_device_sub_types(id, uuid, name)
values (0, '440d7f61-8752-45d6-b871-9aa04e594415', 'Unknown')"
        );
        DB::insert(
            "insert into agent_strings.agent_string_device_sub_types(id, uuid, name)
values (1, '554b3615-b7ee-4860-937d-2ce64fbf9614', 'Feature Phone')"
        );
        DB::insert(
            "insert into agent_strings.agent_string_device_sub_types(id, uuid, name)
values (2, '0d23522d-8d7a-491f-ba28-5794726d9945', 'Smart Phone')"
        );
        DB::insert(
            "insert into agent_strings.agent_string_device_sub_types(id, uuid, name)
values (3, '428c723c-3d1b-4d64-ba6a-ae7db2bb8ae8', 'PC')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert('agent_strings.agent_string_device_sub_types');

        Schema::create(
            'agent_strings.agent_string_device_subs',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id')->unique();
                $table->unsignedBigInteger('agent_string_device_sub_type_id');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
                $table->foreign('agent_string_device_sub_type_id')
                    ->references('id')
                    ->on('agent_strings.agent_string_device_sub_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_subs');

        Schema::create(
            'agent_strings.agent_string_device_sub_wb_types',
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

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_sub_wb_types');


        DB::insert(
            "insert into agent_strings.agent_string_device_sub_wb_types
    (id, uuid, name) values (0, 'c460861e-044e-48c7-9233-533139954d79', 'Unknown')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert('agent_strings.agent_string_device_sub_wb_types');

        Schema::create(
            'agent_strings.agent_string_device_sub_wbs',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id')->unique();
                $table->unsignedBigInteger('agent_string_device_sub_wb_type_id');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
                $table->foreign('agent_string_device_sub_wb_type_id')
                    ->references('id')
                    ->on('agent_strings.agent_string_device_sub_wb_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_sub_wbs');

        Schema::create(
            'agent_strings.agent_string_device_browser_types',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->text('name');
                $table->text('version')->default('');
                $table->unique(['name', 'version']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_browser_types');


        DB::insert(
            "insert into agent_strings.agent_string_device_browser_types
    (id, uuid, name)
    values (0, '2e06f10e-1353-4903-9aad-2b9384b69b45', 'Unknown')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert('agent_strings.agent_string_device_browser_types');

        Schema::create(
            'agent_strings.agent_string_device_browsers',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id')->unique();
                $table->unsignedBigInteger('agent_string_device_browser_type_id');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
                $table->foreign('agent_string_device_browser_type_id')
                    ->references('id')
                    ->on('agent_strings.agent_string_device_browser_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_browsers');

        Schema::create(
            'agent_strings.agent_string_device_browser_engine_types',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->text('name');
                $table->text('version')->default('');
                $table->unique(['name', 'version']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_browser_engine_types');

        DB::insert(
            "insert into agent_strings.agent_string_device_browser_engine_types
    (id, uuid, name)
values
       (0, '978bf78b-ad44-4448-b544-b2e5b1bbc067', 'Unknown')"
        );

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'agent_strings.agent_string_device_browser_engine_types'
        );

        Schema::create(
            'agent_strings.agent_string_device_browser_engines',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id');
                $table->unsignedBigInteger('agent_string_device_browser_engine_type_id');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
                $table->foreign(
                    'agent_string_device_browser_engine_type_id',
                    'agent_string_device_browser_engines_agent_string_device_browser_engine_type_id_foreign'
                )
                    ->references('id')
                    ->on('agent_strings.agent_string_device_browser_engine_types')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_device_browser_engines');

        Schema::create(
            'agent_strings.agent_string_extras',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('agent_string_id')->unique();
                $table->jsonb('data_json');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('agent_strings.agent_string_extras');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('DROP SCHEMA IF EXISTS agent_strings CASCADE');
    }
}
