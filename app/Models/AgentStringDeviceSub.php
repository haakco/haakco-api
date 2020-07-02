<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceSub
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property-read \App\Models\AgentStringDeviceSubType $agent_string_device_sub_type
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSub query()
 * @mixin \Eloquent
 */
class AgentStringDeviceSub extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_subs';

    protected $casts = [
        'agent_string_id' => 'int',
        'agent_string_device_sub_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_id',
        'agent_string_device_sub_type_id'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function agent_string_device_sub_type()
    {
        return $this->belongsTo(\App\Models\AgentStringDeviceSubType::class, 'agent_string_device_sub_type_id');
    }
}
