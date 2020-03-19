<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\FileExtra
 *
 * @property-read \App\Models\File $file
 * @property mixed $data_json
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileExtra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileExtra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileExtra query()
 * @mixin \Eloquent
 */
class FileExtra extends \App\Models\BaseModel\BaseModel
{
    use \App\Models\ModelTraits\DataJsonTrait;



    protected $table = 'files.file_extra';

    protected $casts = [
        'file_id' => 'int',
        'data_json' => 'text'
    ];

    protected $fillable = [
        'file_id',
        'data_json'
    ];

    public function file()
    {
        return $this->belongsTo(\App\Models\File::class, 'file_id');
    }
}
