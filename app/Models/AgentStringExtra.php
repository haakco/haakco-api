<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringExtra
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property mixed $data_json
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringExtra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringExtra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringExtra query()
 * @mixin \Eloquent
 */
class AgentStringExtra extends \App\Models\BaseModel\BaseModel
{
    use \App\Models\ModelTraits\DataJsonTrait;



    protected $table = 'agent_strings.agent_string_extras';

    protected $casts = [
        'agent_string_id' => 'int',
        'data_json' => 'text'
    ];

    protected $fillable = [
        'agent_string_id',
        'data_json'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }
}
