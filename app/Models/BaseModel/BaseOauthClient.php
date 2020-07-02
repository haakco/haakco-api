<?php

namespace App\Models\BaseModel;

use Laravel\Passport\Client;

/**
 * App\Models\BaseModel\BaseOauthClient
 *
 * @property int $id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string $name
 * @property string|null $secret
 * @property string|null $provider
 * @property string $redirect
 * @property bool $personal_access_client
 * @property bool $password_client
 * @property bool $revoked
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthAuthCode[] $authCodes
 * @property-read int|null $auth_codes_count
 * @property-read string|null $plain_secret
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient wherePasswordClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient wherePersonalAccessClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereRedirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthClient whereUserId($value)
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
