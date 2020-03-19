<?php

namespace App\Models\BaseModel;

use Laravel\Passport\Token;

/**
 * App\Models\BaseModel\BaseOauthAccessToken
 *
 * @property string $id
 * @property int|null $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $client_id
 * @property string|null $name
 * @property array|null $scopes
 * @property bool $revoked
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property-read \App\Models\BaseModel\BaseOauthClient $client
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAccessToken whereUserId($value)
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
