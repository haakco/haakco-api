<?php

use App\Libraries\Helper\DatabaseLibrary;
use Illuminate\Database\Migrations\Migration;
use Laravel\Passport\Console\HashCommand;

class AddPassportClient extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        DB::insert(
            "INSERT
INTO
    public.oauth_clients (id, user_id, created_at, updated_at, name, secret, provider, redirect, personal_access_client,
                          password_client, revoked)
VALUES
(1, NULL, '2020-05-20 18:05:00', '2020-05-20 18:05:33', 'haakco Personal Access Client',
 'exQXR4RUlvQI5Tt0e1dDntotMN5Sp9qped6n8WsE', NULL, 'http://localhost', TRUE, FALSE, FALSE);"
        );

        DB::insert(
            "INSERT
INTO
    public.oauth_clients (id, user_id, created_at, updated_at, name, secret, provider, redirect, personal_access_client,
                          password_client, revoked)
VALUES
(2, NULL, '2020-05-20 18:05:00', '2020-05-20 18:05:33', 'haakco Password Grant Client',
 'fmEatZVcOEdpcRRkbjfNF7wCmOZlKUR89suhdFGx', 'users', 'http://localhost', FALSE, TRUE, FALSE);"
        );

        DatabaseLibrary::updateSequenceAfterInsert(
            'public.oauth_clients'
        );
        Artisan::call(
            HashCommand::class,
            [
                '--force' => true,
            ]
        );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        DB::delete('DELETE FROM public.oauth_clients WHERE 1=1;');
    }
}
