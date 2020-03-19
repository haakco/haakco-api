<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\AgentStringDeviceBrowserType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgentStringDeviceBrowser[] $agent_string_device_browsers
 * @property-read int|null $agent_string_device_browsers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgentStringDeviceBrowserType query()
 * @mixin \Eloquent
 */
class AgentStringDeviceBrowserType extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'agent_strings.agent_string_device_browser_types';

    protected $casts = [
        'uuid' => 'uuid'
    ];

    protected $fillable = [
        'name'
    ];

    public function agent_string_device_browsers()
    {
        return $this->hasMany(\App\Models\AgentStringDeviceBrowser::class, 'agent_string_device_browser_type_id');
    }
}
