<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Tag
 *
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Tag[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FileTag[] $file_tags
 * @property-read int|null $file_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FileTypeTag[] $file_type_tags
 * @property-read int|null $file_type_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FileType[] $file_types
 * @property-read int|null $file_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read \App\Models\Tag $parent
 * @property-write mixed $parent_id
 * @property-read \App\Models\Tag $tag
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Tag newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Tag newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Models\Tag query()
 * @mixin \Eloquent
 */
class Tag extends \App\Models\BaseModel\BaseModel
{
    use \Kalnoy\Nestedset\NodeTrait;



    protected $table = 'tags.tags';

    protected $casts = [
        'uuid' => 'uuid',
        '_lft' => 'int',
        '_rgt' => 'int',
        'parent_id' => 'int'
    ];

    protected $fillable = [
        'name',
        '_lft',
        '_rgt',
        'parent_id'
    ];

    public function tag()
    {
        return $this->belongsTo(\App\Models\Tag::class, 'parent_id');
    }

    public function tags()
    {
        return $this->hasMany(\App\Models\Tag::class, 'parent_id');
    }

    public function file_types()
    {
        return $this->belongsToMany(\App\Models\FileType::class, 'files.file_type_tags', 'tag_id')
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function file_type_tags()
    {
        return $this->hasMany(\App\Models\FileTypeTag::class, 'tag_id');
    }

    public function files()
    {
        return $this->belongsToMany(\App\Models\File::class, 'files.file_tags', 'tag_id')
                    ->withPivot('id', 'uuid')
                    ->withTimestamps();
    }

    public function file_tags()
    {
        return $this->hasMany(\App\Models\FileTag::class, 'tag_id');
    }
}
