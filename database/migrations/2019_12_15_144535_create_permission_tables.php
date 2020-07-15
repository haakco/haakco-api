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
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.company_users');

        Schema::create(
            'users.permissions',
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
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.permissions');

        Schema::create(
            'users.roles',
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
                $table->text('name')->unique();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.roles');

        Schema::create(
            'users.user_has_roles',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('company_id');
                $table->unsignedBigInteger('role_id');

                $table->foreign('user_id')
                    ->references('id')
                    ->on('public.users')
                    ->onDelete('cascade');

                $table->foreign('company_id')
                    ->references('id')
                    ->on('users.companies')
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on('users.roles')
                    ->onDelete('cascade');

                $table->unique(
                    [
                        'user_id',
                        'company_id',
                        'role_id',
                    ]
                );
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.user_has_roles');

        Schema::create(
            'users.role_has_permissions',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));

                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('role_id');

                $table->foreign('permission_id')
                    ->references('id')
                    ->on('users.permissions')
                    ->onDelete('cascade');

                $table->foreign('role_id')
                    ->references('id')
                    ->on('users.roles')
                    ->onDelete('cascade');

                $table->unique(
                    [
                        'permission_id',
                        'role_id'
                    ]
                );
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('users.role_has_permissions');
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('users.role_has_permissions');
        Schema::drop('users.user_has_roles');
        Schema::drop('users.roles');
        Schema::drop('users.permissions');
        Schema::drop('users.company_users');
        Schema::drop('users.companies');
    }
}
