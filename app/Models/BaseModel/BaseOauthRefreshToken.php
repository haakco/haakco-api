<?php

namespace App\Models\BaseModel;

use Laravel\Passport\RefreshToken;

/**
 * App\Models\BaseModel\BaseOauthRefreshToken
 *
 * @property-read \App\Models\BaseModel\BaseOauthAccessToken $accessToken
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken query()
 * @mixin \Eloquent
 */
class BaseOauthRefreshToken extends RefreshToken
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
