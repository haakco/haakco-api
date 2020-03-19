<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert('CREATE SCHEMA short_urls');

        Schema::create(
            'short_urls.short_urls',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('dt_deleted')->nullable();
                $table->text('full_url');
                $table->text('short_url')->default('');
                $table->index(['uuid']);
                $table->index(['short_url']);
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('short_urls.short_urls');

        Schema::create(
            'short_urls.short_url_tracking',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('short_url_id');
                $table->unsignedBigInteger('agent_string_id');
                $table->ipAddress('ip');
                $table->ipAddress('proxy_ip');
                $table->foreign('short_url_id')
                    ->references('id')
                    ->on('short_urls.short_urls')
                    ->onDelete('cascade');
                $table->foreign('agent_string_id')
                    ->references('id')
                    ->on('agent_strings.agent_strings')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('short_urls.short_url_tracking');

        Schema::create(
            'short_urls.short_url_tracking_extra',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->unsignedBigInteger('short_url_tracking_id');
                $table->jsonb('data_json');
                $table->foreign('short_url_tracking_id')
                    ->references('id')
                    ->on('short_urls.short_url_tracking')
                    ->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('short_urls.short_url_tracking_extra');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('DROP SCHEMA IF EXISTS short_urls CASCADE');
    }
}
