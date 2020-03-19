<?php

use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class RunFullDmImport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $process = new Process(
            [database_path('restorDb.sh')],
            null,
            [
                'DB_RESTORE_FILE_NAME' => database_path('haak.co.sql.xz'),
                'DB_HOST' => config('database.connections.pgsql.write.host')[0],
                'DB_USER' => config('database.connections.pgsql.username'),
                'DB_NAME' => config('database.connections.pgsql.database'),
                'DB_PWD' => config('database.connections.pgsql.password'),
            ]
        );
        $process->run();

// executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
