<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceManufacturer
 *
 * @property-read \App\Models\AgentString $agent_string
 * @property-read \App\Models\AgentStringDeviceManufacturerType $agent_string_device_manufacturer_type
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceManufacturer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceManufacturer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceManufacturer query()
 * @mixin \Eloquent
 */
class AgentStringDeviceManufacturer extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_manufacturers';

    protected $casts = [
        'agent_string_id' => 'int',
        'agent_string_device_manufacturer_type_id' => 'int'
    ];

    protected $fillable = [
        'agent_string_id',
        'agent_string_device_manufacturer_type_id'
    ];

    public function agent_string()
    {
        return $this->belongsTo(\App\Models\AgentString::class, 'agent_string_id');
    }

    public function agent_string_device_manufacturer_type()
    {
        return $this->belongsTo(\App\Models\AgentStringDeviceManufacturerType::class, 'agent_string_device_manufacturer_type_id');
    }
}
