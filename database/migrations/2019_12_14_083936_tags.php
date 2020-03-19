<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert('CREATE SCHEMA tags');
        Schema::create(
            'tags.tags',
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
                $table->unsignedBigInteger('_lft');
                $table->unsignedBigInteger('_rgt');
                $table->unsignedBigInteger('parent_id');
                $table->unique(
                    [
                        'parent_id',
                        'name',
                    ]
                );
                $table->index(
                    [
                        '_lft',
                        '_rgt',
                        'parent_id',
                    ]
                );
                $table->foreign('parent_id')->references('id')->on('tags.tags')->onDelete('cascade');
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('tags.tags');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('DROP SCHEMA IF EXISTS tags CASCADE');
    }
}
