<?php

namespace App\Models\BaseModel;

use Laravel\Passport\PersonalAccessClient;

/**
 * App\Models\BaseModel\BaseOauthPersonalAccessClient
 *
 * @property-read \App\Models\BaseModel\BaseOauthClient $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient query()
 * @mixin \Eloquent
 */
class BaseOauthPersonalAccessClient extends PersonalAccessClient
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
