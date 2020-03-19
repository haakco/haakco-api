<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTranslationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ltm_translations',
            function (Blueprint $table) {
                $table->collation = 'utf8mb4_bin';
                $table->bigIncrements('id');
                $table->uuid('uuid')
                    ->default(\Illuminate\Support\Facades\DB::raw('uuid_generate_v4()'))
                    ->unique();
                $table->timestampTz('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestampTz('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->integer('status')->default(0);
                $table->text('locale');
                $table->text('group');
                $table->text('key');
                $table->text('value')->nullable();
            }
        );

        \App\Libraries\Helper\DatabaseLibrary::setUpdatedAtTrigger('ltm_translations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ltm_translations');
    }
}
