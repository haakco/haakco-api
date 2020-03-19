<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\File
 *
 * @property-read \App\Models\Extension $extension
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FileExtra[] $file_extras
 * @property-read int|null $file_extras_count
 * @property-read \App\Models\FileSection $file_section
 * @property-read \App\Models\FileStorageType $file_storage_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FileTag[] $file_tags
 * @property-read int|null $file_tags_count
 * @property-read \App\Models\FileType $file_type
 * @property-read \App\Models\MimeType $mime_type
 * @property-read \Kalnoy\Nestedset\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserImage[] $user_images
 * @property-read int|null $user_images_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File query()
 * @mixin \Eloquent
 */
class File extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.files';

    protected $casts = [
        'uuid' => 'uuid',
        'file_storage_type_id' => 'int',
        'file_type_id' => 'int',
        'file_section_id' => 'int',
        'mime_type_id' => 'int',
        'extension_id' => 'int',
        'is_private' => 'boolean'
    ];

    protected $fillable = [
        'file_storage_type_id',
        'file_type_id',
        'file_section_id',
        'mime_type_id',
        'extension_id',
        'is_private',
        'name',
        'url',
        'original_file_name'
    ];

    public function file_storage_type()
    {
        return $this->belongsTo(\App\Models\FileStorageType::class, 'file_storage_type_id');
    }

    public function file_type()
    {
        return $this->belongsTo(\App\Models\FileType::class, 'file_type_id');
    }

    public function file_section()
    {
        return $this->belongsTo(\App\Models\FileSection::class, 'file_section_id');
    }

    public function mime_type()
    {
        return $this->belongsTo(\App\Models\MimeType::class, 'mime_type_id');
    }

    public function extension()
    {
        return $this->belongsTo(\App\Models\Extension::class, 'extension_id');
    }

    public function tags()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'files.file_tags', 'file_id')
                    ->withPivot('id', 'uuid')
                    ->withTimestamps();
    }

    public function file_tags()
    {
        return $this->hasMany(\App\Models\FileTag::class, 'file_id');
    }

    public function file_extras()
    {
        return $this->hasMany(\App\Models\FileExtra::class, 'file_id');
    }

    public function user_images()
    {
        return $this->hasMany(\App\Models\UserImage::class, 'file_id');
    }
}
