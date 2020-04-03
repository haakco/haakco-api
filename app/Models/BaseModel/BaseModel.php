<?php

namespace App\Models\BaseModel;

use Reliese\Database\Eloquent\Model;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\BaseModel\BaseModel
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    use Rememberable;
    use HasUuidRouteKey;

    /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
