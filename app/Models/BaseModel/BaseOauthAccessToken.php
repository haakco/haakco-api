<?php

namespace App\Models\BaseModel;

use Laravel\Passport\Token;

/**
 * App\Models\BaseModel\BaseOauthAccessToken
 *
 * @property-read \App\Models\BaseModel\BaseOauthClient $client
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken query()
 * @mixin \Eloquent
 */
class BaseOauthAccessToken extends Token
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
