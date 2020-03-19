<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\MimeType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Extension[] $extensions
 * @property-read int|null $extensions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MimeTypeExtension[] $mime_type_extensions
 * @property-read int|null $mime_type_extensions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MimeTypeExtra[] $mime_type_extras
 * @property-read int|null $mime_type_extras_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MimeTypeName[] $mime_type_names
 * @property-read int|null $mime_type_names_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeType query()
 * @mixin \Eloquent
 */
class MimeType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.mime_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function files()
    {
        return $this->hasMany(\App\Models\File::class, 'mime_type_id');
    }

    public function extensions()
    {
        return $this->belongsToMany(\App\Models\Extension::class, 'files.mime_type_extensions', 'mime_type_id')
                    ->withPivot('id', 'uuid')
                    ->withTimestamps();
    }

    public function mime_type_extensions()
    {
        return $this->hasMany(\App\Models\MimeTypeExtension::class, 'mime_type_id');
    }

    public function mime_type_extras()
    {
        return $this->hasMany(\App\Models\MimeTypeExtra::class, 'mime_type_id');
    }

    public function mime_type_names()
    {
        return $this->hasMany(\App\Models\MimeTypeName::class, 'mime_type_id');
    }
}
