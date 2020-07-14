<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringOperatingSystemType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringOperatingSystemVersionType[] $agent_string_operating_system_version_types
 * @property-read int|null $agent_string_operating_system_version_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringOperatingSystem[] $agent_string_operating_systems
 * @property-read int|null $agent_string_operating_systems_count
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystemType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystemType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringOperatingSystemType query()
 * @mixin \Eloquent
 */
class AgentStringOperatingSystemType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_operating_system_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function agent_string_operating_system_version_types()
    {
        return $this->hasMany(\App\Models\AgentStringOperatingSystemVersionType::class, 'agent_string_operating_system_type_id');
    }

    public function agent_string_operating_systems()
    {
        return $this->hasMany(\App\Models\AgentStringOperatingSystem::class, 'agent_string_operating_system_type_id');
    }
}
