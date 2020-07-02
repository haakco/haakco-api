<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceModel
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property-read \App\Models\AgentStringDeviceModelType $agent_string_device_model_type
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceModel query()
 * @mixin \Eloquent
 */
class AgentStringDeviceModel extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_models';

    protected $casts = [
        'agent_string_id' => 'int',
        'agent_string_device_model_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_id',
        'agent_string_device_model_type_id'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function agent_string_device_model_type()
    {
        return $this->belongsTo(\App\Models\AgentStringDeviceModelType::class, 'agent_string_device_model_type_id');
    }
}
