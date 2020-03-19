<?php

namespace App\Models\BaseModel;

use Laravel\Passport\AuthCode;

/**
 * App\Models\BaseModel\BaseOauthAuthCode
 *
 * @property-read \App\Models\BaseModel\BaseOauthClient $client
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseOauthAuthCode query()
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
