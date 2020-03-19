<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringOperatingSystemVersionType
 *
 * @property-read \App\Models\AgentStringOperatingSystemType $agent_string_operating_system_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringOperatingSystem[] $agent_string_operating_systems
 * @property-read int|null $agent_string_operating_systems_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystemVersionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystemVersionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystemVersionType query()
 * @mixin \Eloquent
 */
class AgentStringOperatingSystemVersionType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_operating_system_version_types';

    protected $casts = [
        'uuid' => 'uuid',
        'agent_string_operating_system_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_operating_system_type_id',
        'name'
    ];

    public function agent_string_operating_system_type()
    {
        return $this->belongsTo(\App\Models\AgentStringOperatingSystemType::class, 'agent_string_operating_system_type_id');
    }

    public function agent_string_operating_systems()
    {
        return $this->hasMany(\App\Models\AgentStringOperatingSystem::class, 'agent_string_operating_system_version_type_id');
    }
}
