<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebSocketsStatisticsEntriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('websockets_statistics_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_id');
            $table->bigInteger('peak_connection_count');
            $table->bigInteger('websocket_message_count');
            $table->bigInteger('api_message_count');
            $table->nullableTimestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('websockets_statistics_entries');
    }
}
