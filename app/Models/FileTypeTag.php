<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\FileTypeTag
 *
 * @property-read \App\Models\FileType $file_type
 * @property \UuidInterface $uuid
 * @property-read \App\Models\Tag $tag
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileTypeTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileTypeTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileTypeTag query()
 * @mixin \Eloquent
 */
class FileTypeTag extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.file_type_tags';

    protected $casts = [
        'uuid' => 'uuid',
        'file_type_id' => 'int',
        'tag_id' => 'int'
    ];

    protected $fillable = [
        'file_type_id',
        'tag_id'
    ];

    public function file_type()
    {
        return $this->belongsTo(\App\Models\FileType::class, 'file_type_id');
    }

    public function tag()
    {
        return $this->belongsTo(\App\Models\Tag::class, 'tag_id');
    }
}
