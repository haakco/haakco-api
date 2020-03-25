<?php

namespace App\Models\BaseModel;

use Laravel\Passport\RefreshToken;

/**
 * App\Models\BaseModel\BaseOauthRefreshToken
 *
 * @property string $id
 * @property string $access_token_id
 * @property bool $revoked
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property-read \App\Models\BaseModel\BaseOauthAccessToken $accessToken
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken whereAccessTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthRefreshToken whereRevoked($value)
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
