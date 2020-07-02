<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceSubWb
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property-read \App\Models\AgentStringDeviceSubWbType $agent_string_device_sub_wb_type
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubWb newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubWb newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubWb query()
 * @mixin \Eloquent
 */
class AgentStringDeviceSubWb extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_sub_wbs';

    protected $casts = [
        'agent_string_id' => 'int',
        'agent_string_device_sub_wb_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_id',
        'agent_string_device_sub_wb_type_id'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function agent_string_device_sub_wb_type()
    {
        return $this->belongsTo(\App\Models\AgentStringDeviceSubWbType::class, 'agent_string_device_sub_wb_type_id');
    }
}
