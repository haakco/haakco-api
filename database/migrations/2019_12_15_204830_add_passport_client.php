<?php

use Illuminate\Database\Migrations\Migration;

class AddPassportClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert("INSERT INTO
    public.oauth_clients
    (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked)
    VALUES
           (1, null, 'HaakCo Password Grant Client', '3fj8GVtEohIX82OHk4DsrrdYbH10LYq3zd338bkU', 'http://localhost', false, true, false);");

        DB::insert("INSERT INTO
    public.oauth_clients
    (id, user_id, name, secret, redirect, personal_access_client, password_client, revoked)
    VALUES
           (2, null, 'HaakCo Personal Access Client', 'kBNfMqUpebTupCjQRyPDUpOQ9T7R63oC8Yc3dcQy', 'http://localhost', true, false, false);");

        \App\Libraries\Helper\DatabaseLibrary::updateSequenceAfterInsert(
            'public.oauth_clients'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('DELETE FROM public.oauth_clients WHERE 1=1;');
    }
}
