<?php

namespace App\Models\BaseModel;

use Laravel\Passport\PersonalAccessClient;

/**
 * App\Models\BaseModel\BaseOauthPersonalAccessClient
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $client_id
 * @property-read \App\Models\BaseModel\BaseOauthClient $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthPersonalAccessClient whereUpdatedAt($value)
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
