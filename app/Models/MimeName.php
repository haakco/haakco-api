<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\MimeName
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MimeTypeName[] $mime_type_names
 * @property-read int|null $mime_type_names_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MimeName query()
 * @mixin \Eloquent
 */
class MimeName extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.mime_names';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function mime_type_names()
    {
        return $this->hasMany(\App\Models\MimeTypeName::class, 'mime_name_id');
    }
}
