<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\Taggable
 *
 * @property int $tag_id
 * @property \UuidInterface $uuid
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string $taggable_type
 * @property int $taggable_id
 * @property-read \App\Models\Tag $tag
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereTaggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereTaggableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taggable whereUuid($value)
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
