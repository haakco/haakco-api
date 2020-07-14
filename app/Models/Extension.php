<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Extension
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MimeTypeExtension[] $mime_type_extensions
 * @property-read int|null $mime_type_extensions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MimeType[] $mime_types
 * @property-read int|null $mime_types_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extension newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extension query()
 * @mixin \Eloquent
 */
class Extension extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.extensions';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function files()
    {
        return $this->hasMany(\App\Models\File::class, 'extension_id');
    }

    public function mime_types()
    {
        return $this->belongsToMany(\App\Models\MimeType::class, 'files.mime_type_extensions', 'extension_id')
                    ->withPivot('id', 'uuid')
                    ->withTimestamps();
    }

    public function mime_type_extensions()
    {
        return $this->hasMany(\App\Models\MimeTypeExtension::class, 'extension_id');
    }
}
