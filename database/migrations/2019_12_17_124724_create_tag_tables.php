
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagTables extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')
                ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                ->unique();
            $table->timestampTz('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('updated_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->jsonb('name');
            $table->jsonb('slug');
            $table->text('type')->nullable();
            $table->bigInteger('order_column')->nullable();
        });

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('tags');

        Schema::create('taggables', function (Blueprint $table) {
            $table->bigIncrements('tag_id')->unsigned();
            $table->timestampTz('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('updated_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->morphs('taggable');

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('taggables');
    }

    public function down()
    {
        Schema::drop('taggables');
        Schema::drop('tags');
    }
}
