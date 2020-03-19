<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceBrowserEngineType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceBrowserEngine[] $agent_string_device_browser_engines
 * @property-read int|null $agent_string_device_browser_engines_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserEngineType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserEngineType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserEngineType query()
 * @mixin \Eloquent
 */
class AgentStringDeviceBrowserEngineType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_browser_engine_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name',
        'version'
    ];

    public function agent_string_device_browser_engines()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceBrowserEngine::class, 'agent_string_device_browser_engine_type_id');
    }
}
