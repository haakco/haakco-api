<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentString
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceBrowserEngine[] $agent_string_device_browser_engines
 * @property-read int|null $agent_string_device_browser_engines_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceBrowser[] $agent_string_device_browsers
 * @property-read int|null $agent_string_device_browsers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceManufacturer[] $agent_string_device_manufacturers
 * @property-read int|null $agent_string_device_manufacturers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceModel[] $agent_string_device_models
 * @property-read int|null $agent_string_device_models_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceSubWb[] $agent_string_device_sub_wbs
 * @property-read int|null $agent_string_device_sub_wbs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceSub[] $agent_string_device_subs
 * @property-read int|null $agent_string_device_subs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDevice[] $agent_string_devices
 * @property-read int|null $agent_string_devices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringExtra[] $agent_string_extras
 * @property-read int|null $agent_string_extras_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringOperatingSystem[] $agent_string_operating_systems
 * @property-read int|null $agent_string_operating_systems_count
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShortUrlTracking[] $short_url_trackings
 * @property-read int|null $short_url_trackings_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentString newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentString newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentString query()
 * @mixin \Eloquent
 */
class AgentString extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_strings';

    protected $casts = [
        'uuid' => 'uuid',
        'parsed' => 'boolean'
    ];

    protected $fillable = [
        'parsed',
        'name'
    ];

    public function agent_string_device_models()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceModel::class, 'agent_string_id');
    }

    public function agent_string_device_browsers()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceBrowser::class, 'agent_string_id');
    }

    public function agent_string_device_browser_engines()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceBrowserEngine::class, 'agent_string_id');
    }

    public function agent_string_operating_systems()
    {
        return $this->hasMany(\App\Models\AgentStringOperatingSystem::class, 'agent_string_id');
    }

    public function agent_string_devices()
    {
        return $this->hasMany(\App\Models\AgentStringDevice::class, 'agent_string_id');
    }

    public function agent_string_device_subs()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceSub::class, 'agent_string_id');
    }

    public function agent_string_extras()
    {
        return $this->hasMany(\App\Models\AgentStringExtra::class, 'agent_string_id');
    }

    public function agent_string_device_manufacturers()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceManufacturer::class, 'agent_string_id');
    }

    public function agent_string_device_sub_wbs()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceSubWb::class, 'agent_string_id');
    }

    public function short_url_trackings()
    {
        return $this->hasMany(\App\Models\ShortUrlTracking::class, 'agent_string_id');
    }
}
