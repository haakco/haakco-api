<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\FileTag
 *
 * @property-read \App\Models\File $file
 * @property-read \App\Models\Tag $tag
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileTag query()
 * @mixin \Eloquent
 */
class FileTag extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.file_tags';

    protected $casts = [
        'uuid' => 'uuid',
        'file_id' => 'int',
        'tag_id' => 'int'
    ];

    protected $fillable = [
        'file_id',
        'tag_id'
    ];

    public function file()
    {
        return $this->belongsTo(\App\Models\File::class, 'file_id');
    }

    public function tag()
    {
        return $this->belongsTo(\App\Models\Tag::class, 'tag_id');
    }
}
