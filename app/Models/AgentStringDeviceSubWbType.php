<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceSubWbType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceSubWb[] $agent_string_device_sub_wbs
 * @property-read int|null $agent_string_device_sub_wbs_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubWbType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubWbType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceSubWbType query()
 * @mixin \Eloquent
 */
class AgentStringDeviceSubWbType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_sub_wb_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function agent_string_device_sub_wbs()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceSubWb::class, 'agent_string_device_sub_wb_type_id');
    }
}
