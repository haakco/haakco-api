<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDevice[] $agent_string_devices
 * @property-read int|null $agent_string_devices_count
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceType query()
 * @mixin \Eloquent
 */
class AgentStringDeviceType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function agent_string_devices()
    {
        return $this->hasMany(\App\Models\AgentStringDevice::class, 'agent_string_device_type_id');
    }
}
