<?php

namespace App\Models\BaseModel;

use Laravel\Passport\Client;

/**
 * App\Models\BaseModel\BaseOauthClient
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthAuthCode[] $authCodes
 * @property-read int|null $auth_codes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient query()
 * @mixin \Eloquent
 */
class BaseOauthClient extends Client
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
