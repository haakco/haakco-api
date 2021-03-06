<?php

namespace App\Libraries\AgentString;

use App\Models\AgentString;
use App\Models\Enum\AgentStringDeviceSubTypesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AgentStringLibrary
{
    private $agentStringCachingTimeMinutes = 3600;

    /**
     * @param string $agentStr
     *
     * @return AgentString|Builder|Model|object|string|null
     */
    public function getAgentString($agentStr = '')
    {
        return Cache::remember(
            'agent_string_' . $agentStr,
            now()->addMinutes($this->agentStringCachingTimeMinutes),
            function () use ($agentStr) {

                $agentString = AgentString::query()
                    ->where('name', $agentStr)
                    ->first();

                if (!$agentString) {
                    $agentString = AgentString::create(
                        [
                            'parsed' => false,
                            'name' => $agentStr,
                        ]
                    );
                    $agentStringParsingLibrary = new AgentStringParsingLibrary();
                    $agentStringParsingLibrary->parseAgentStrings($agentString);
                }
                return $agentString;
            }
        );
    }


    public function getAgentStringAll($agentStr = '')
    {
        return Cache::remember(
            'agent_string_all' . $agentStr,
            now()->addMinutes($this->agentStringCachingTimeMinutes),
            function () use ($agentStr) {

                $agentString = $this->getAgentString($agentStr);
                $agentString->load(
                    [
                        'agent_string_device_browsers.agent_string_device_browser_type',
                        'agent_string_device_browser_engines.agent_string_device_browser_engine_type',
                        'agent_string_device_manufacturers.agent_string_device_manufacturer_type',
                        'agent_string_device_models.agent_string_device_model_type',
                        'agent_string_device_subs.agent_string_device_sub_type',
                        'agent_string_device_sub_wbs.agent_string_device_sub_wb_type',
                        'agent_string_devices.agent_string_device_type',
                        'agent_string_operating_systems.agent_string_operating_system_type',
                        'agent_string_operating_systems.agent_string_operating_system_version_type',
                    ]
                );
                return $agentString;
            }
        );
    }

    public function getAgentStringDeviceSubtype($agentStr = '')
    {
        return Cache::remember(
            'agent_string_device_sub_type' . $agentStr,
            now()->addMinutes($this->agentStringCachingTimeMinutes),
            function () use ($agentStr) {

                $agentString = $this->getAgentString($agentStr);
                $agentString->load('deviceSubTypes');
                return $agentString;
            }
        );
    }

    public function isDeviceType($agentStr = '', $deviceTypeId = AgentStringDeviceSubTypesEnum::FEATURE_PHONE_ID)
    {
        return Cache::remember(
            'agent_string_' . $agentStr . '_isDeviceType' . $deviceTypeId,
            now()->addMinutes($this->agentStringCachingTimeMinutes),
            function () use ($agentStr, $deviceTypeId) {
                $agentString = $this->getAgentString($agentStr);
                $agentString->load('deviceSubTypes');

                foreach ($agentString->deviceSubTypes as $deviceSubType) {
                    if ($deviceSubType->id === $deviceTypeId) {
                        return true;
                    }
                }
                return false;
            }
        );
    }
}
