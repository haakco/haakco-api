<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users.companies',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('deleted_at')->nullable();
                $table->boolean('is_system')->default(false);
                $table->text('name')->unique();
                $table->text('slug')->unique();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.companies');


        Schema::create(
            'users.company_users',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('deleted_at')->nullable();
                $table->unsignedBigInteger('company_id');
                $table->unsignedBigInteger('user_id');
                $table->boolean('is_owner')->default(false);

                $table->foreign('company_id')
                    ->references('id')
                    ->on('users.companies')
                    ->onDelete('cascade');

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.company_users');

        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        Schema::create(
            $tableNames['permissions'],
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('deleted_at')->nullable();
                $table->boolean('is_system')->default(false);
                $table->text('name');
                $table->text('guard_name');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger($tableNames['permissions']);

        Schema::create(
            $tableNames['roles'],
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('deleted_at')->nullable();
                $table->boolean('is_system')->default(false);
                $table->boolean('is_default')->default(false);
                $table->text('name');
                $table->text('guard_name');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger($tableNames['roles']);

        Schema::create(
            'users.company_roles',
            function (Blueprint $table) use ($tableNames) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('company_id');
                $table->unsignedBigInteger('role_id');

                $table->foreign('company_id')
                    ->references('id')
                    ->on('users.companies')
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

                $table->unique(['company_id', 'role_id']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.company_roles');

        Schema::create(
            $tableNames['model_has_permissions'],
            function (Blueprint $table) use ($tableNames, $columnNames) {
                $table->unsignedBigInteger('permission_id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();

                $table->text('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->index(
                    [$columnNames['model_morph_key'], 'model_type',],
                    'model_has_permissions_model_id_model_type_index'
                );

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');

                $table->primary(
                    ['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary'
                );
            }
        );

        Schema::create(
            $tableNames['model_has_roles'],
            function (Blueprint $table) use ($tableNames, $columnNames) {
                $table->unsignedBigInteger('role_id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();

                $table->text('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->unsignedBigInteger('company_id');

                $table->index(
                    [$columnNames['model_morph_key'], 'model_type',],
                    'model_has_roles_model_id_model_type_index'
                );

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

                $table->primary(
                    ['role_id', $columnNames['model_morph_key'], 'company_id', 'model_type'],
                    'model_has_roles_role_model_type_primary'
                );

                $table->foreign('company_id')
                    ->references('id')
                    ->on('users.companies')
                    ->onDelete('cascade');
            }
        );

        Schema::create(
            $tableNames['role_has_permissions'],
            function (Blueprint $table) use ($tableNames) {
                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('role_id');

                $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

                $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
            }
        );

        app('cache')
            ->store(config('permission.cache.store') !== 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop('users.company_roles');
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
        Schema::drop('users.company_users');
        Schema::drop('users.companies');
    }
}
