<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceManufacturerType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceManufacturer[] $agent_string_device_manufacturers
 * @property-read int|null $agent_string_device_manufacturers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceManufacturerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceManufacturerType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceManufacturerType query()
 * @mixin \Eloquent
 */
class AgentStringDeviceManufacturerType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_manufacturer_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function agent_string_device_manufacturers()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceManufacturer::class, 'agent_string_device_manufacturer_type_id');
    }
}
