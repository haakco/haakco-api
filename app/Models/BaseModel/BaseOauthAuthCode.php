<?php

namespace App\Models\BaseModel;

use Laravel\Passport\AuthCode;

/**
 * App\Models\BaseModel\BaseOauthAuthCode
 *
 * @property string $id
 * @property int $user_id
 * @property int $client_id
 * @property string|null $scopes
 * @property bool $revoked
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property-read \App\Models\BaseModel\BaseOauthClient $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode whereUserId($value)
 * @mixin \Eloquent
 */
class BaseOauthAuthCode extends AuthCode
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
