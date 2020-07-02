<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\MimeTypeExtra
 *
 * @property mixed $data_json
 * @property \UuidInterface $uuid
 * @property-read \App\Models\MimeType $mime_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeExtra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeExtra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeTypeExtra query()
 * @mixin \Eloquent
 */
class MimeTypeExtra extends \App\Models\BaseModel\BaseModel
{
    use \App\Models\ModelTraits\DataJsonTrait;



    protected $table = 'files.mime_type_extra';

    protected $casts = [
        'uuid' => 'uuid',
        'mime_type_id' => 'int',
        'data_json' => 'text'
    ];

    protected $fillable = [
        'mime_type_id',
        'data_json'
    ];

    public function mime_type()
    {
        return $this->belongsTo(\App\Models\MimeType::class, 'mime_type_id');
    }
}
