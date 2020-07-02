<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\MimeTypeName
 *
 * @property \UuidInterface $uuid
 * @property-read \App\Models\MimeName $mime_name
 * @property-read \App\Models\MimeType $mime_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeName query()
 * @mixin \Eloquent
 */
class MimeTypeName extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.mime_type_names';

    protected $casts = [
        'uuid' => 'uuid',
        'mime_type_id' => 'int',
        'mime_name_id' => 'int'
    ];

    protected $fillable = [
        'mime_type_id',
        'mime_name_id'
    ];

    public function mime_type()
    {
        return $this->belongsTo(\App\Models\MimeType::class, 'mime_type_id');
    }

    public function mime_name()
    {
        return $this->belongsTo(\App\Models\MimeName::class, 'mime_name_id');
    }
}
