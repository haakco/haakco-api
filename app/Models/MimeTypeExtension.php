<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\MimeTypeExtension
 *
 * @property-read \App\Models\Extension $extension
 * @property-read \App\Models\MimeType $mime_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeExtension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeExtension newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeExtension query()
 * @mixin \Eloquent
 */
class MimeTypeExtension extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.mime_type_extensions';

    protected $casts = [
        'uuid' => 'uuid',
        'mime_type_id' => 'int',
        'extension_id' => 'int'
    ];

    protected $fillable = [
        'mime_type_id',
        'extension_id'
    ];

    public function mime_type()
    {
        return $this->belongsTo(\App\Models\MimeType::class, 'mime_type_id');
    }

    public function extension()
    {
        return $this->belongsTo(\App\Models\Extension::class, 'extension_id');
    }
}
