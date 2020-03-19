<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\UserImage
 *
 * @property-read \App\Models\File $file
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserImage newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserImage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserImage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserImage withoutTrashed()
 * @mixin \Eloquent
 */
class UserImage extends \App\Models\BaseModel\BaseModel
{
    use \Illuminate\Database\Eloquent\SoftDeletes;



    protected $table = 'users.user_image';

    protected $casts = [
        'user_id' => 'int',
        'file_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'file_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function file()
    {
        return $this->belongsTo(\App\Models\File::class, 'file_id');
    }
}
