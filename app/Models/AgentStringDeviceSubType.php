<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceSubType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceSub[] $agent_string_device_subs
 * @property-read int|null $agent_string_device_subs_count
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubType query()
 * @mixin \Eloquent
 */
class AgentStringDeviceSubType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_sub_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function agent_string_device_subs()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceSub::class, 'agent_string_device_sub_type_id');
    }
}
