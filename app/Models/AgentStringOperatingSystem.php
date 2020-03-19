<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringOperatingSystem
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property-read \App\Models\AgentStringOperatingSystemType $agent_string_operating_system_type
 * @property-read \App\Models\AgentStringOperatingSystemVersionType $agent_string_operating_system_version_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystem query()
 * @mixin \Eloquent
 */
class AgentStringOperatingSystem extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_operating_systems';

    protected $casts = [
        'agent_string_id' => 'int',
        'agent_string_operating_system_type_id' => 'int',
        'agent_string_operating_system_version_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_id',
        'agent_string_operating_system_type_id',
        'agent_string_operating_system_version_type_id'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function agent_string_operating_system_type()
    {
        return $this->belongsTo(\App\Models\AgentStringOperatingSystemType::class, 'agent_string_operating_system_type_id');
    }

    public function agent_string_operating_system_version_type()
    {
        return $this->belongsTo(\App\Models\AgentStringOperatingSystemVersionType::class, 'agent_string_operating_system_version_type_id');
    }
}
