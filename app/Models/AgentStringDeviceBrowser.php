<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceBrowser
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property-read \App\Models\AgentStringDeviceBrowserType $agent_string_device_browser_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowser query()
 * @mixin \Eloquent
 */
class AgentStringDeviceBrowser extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_browsers';

    protected $casts = [
        'agent_string_id' => 'int',
        'agent_string_device_browser_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_id',
        'agent_string_device_browser_type_id'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function agent_string_device_browser_type()
    {
        return $this->belongsTo(\App\Models\AgentStringDeviceBrowserType::class, 'agent_string_device_browser_type_id');
    }
}
