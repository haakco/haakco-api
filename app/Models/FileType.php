<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\FileType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FileTypeTag[] $file_type_tags
 * @property-read int|null $file_type_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property \UuidInterface $uuid
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileType query()
 * @mixin \Eloquent
 */
class FileType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.file_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function tags()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'files.file_type_tags', 'file_type_id')
                    ->withPivot('id', 'uuid')
                    ->withTimestamps();
    }

    public function file_type_tags()
    {
        return $this->hasMany(\App\Models\FileTypeTag::class, 'file_type_id');
    }

    public function files()
    {
        return $this->hasMany(\App\Models\File::class, 'file_type_id');
    }
}
