<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\FileSection
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileSection query()
 * @mixin \Eloquent
 */
class FileSection extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'files.file_sections';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name',
        'directory'
    ];

    public function files()
    {
        return $this->hasMany(\App\Models\File::class, 'file_section_id');
    }
}
