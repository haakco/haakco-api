<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceBrowserEngine
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property-read \App\Models\AgentStringDeviceBrowserEngineType $agent_string_device_browser_engine_type
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserEngine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserEngine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserEngine query()
 * @mixin \Eloquent
 */
class AgentStringDeviceBrowserEngine extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_browser_engines';

    protected $casts = [
        'agent_string_id' => 'int',
        'agent_string_device_browser_engine_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_id',
        'agent_string_device_browser_engine_type_id'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function agent_string_device_browser_engine_type()
    {
        return $this->belongsTo(\App\Models\AgentStringDeviceBrowserEngineType::class, 'agent_string_device_browser_engine_type_id');
    }
}
