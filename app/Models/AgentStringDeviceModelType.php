<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceModelType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceModel[] $agent_string_device_models
 * @property-read int|null $agent_string_device_models_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceModelType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceModelType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceModelType query()
 * @mixin \Eloquent
 */
class AgentStringDeviceModelType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_model_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name',
        'identifier',
        'version',
        'url'
    ];

    public function agent_string_device_models()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceModel::class, 'agent_string_device_model_type_id');
    }
}
