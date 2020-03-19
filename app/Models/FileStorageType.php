<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\FileStorageType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileStorageType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileStorageType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileStorageType query()
 * @mixin \Eloquent
 */
class FileStorageType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.file_storage_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function files()
    {
        return $this->hasMany(\App\Models\File::class, 'file_storage_type_id');
    }
}
