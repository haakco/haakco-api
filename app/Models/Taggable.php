<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Taggable
 *
 * @property-read \App\Models\Tag $tag
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable query()
 * @mixin \Eloquent
 */
class Taggable extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'public.taggables';
    protected $primaryKey = 'tag_id';

    protected $casts = [
        'taggable_id' => 'int'
    ];

    protected $fillable = [
        'taggable_type',
        'taggable_id'
    ];

    public function tag()
    {
        return $this->belongsTo(\App\Models\Tag::class, 'tag_id');
    }
}
