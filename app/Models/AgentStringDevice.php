<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDevice
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property-read \App\Models\AgentStringDeviceType $agent_string_device_type
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDevice query()
 * @mixin \Eloquent
 */
class AgentStringDevice extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_devices';

    protected $casts = [
        'agent_string_id' => 'int',
        'agent_string_device_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_id',
        'agent_string_device_type_id'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function agent_string_device_type()
    {
        return $this->belongsTo(\App\Models\AgentStringDeviceType::class, 'agent_string_device_type_id');
    }
}
