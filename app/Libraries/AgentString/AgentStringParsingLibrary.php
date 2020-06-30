<?php

namespace App\Libraries\AgentString;

use App\Jobs\AgentStringParseJob;
use App\Models\AgentString;
use App\Models\AgentStringDevice;
use App\Models\AgentStringDeviceBrowser;
use App\Models\AgentStringDeviceBrowserEngine;
use App\Models\AgentStringDeviceBrowserEngineType;
use App\Models\AgentStringDeviceBrowserType;
use App\Models\AgentStringDeviceManufacturer;
use App\Models\AgentStringDeviceManufacturerType;
use App\Models\AgentStringDeviceModel;
use App\Models\AgentStringDeviceModelType;
use App\Models\AgentStringDeviceSub;
use App\Models\AgentStringDeviceSubType;
use App\Models\AgentStringDeviceSubWb;
use App\Models\AgentStringDeviceSubWbType;
use App\Models\AgentStringDeviceType;
use App\Models\AgentStringExtra;
use App\Models\AgentStringOperatingSystem;
use App\Models\AgentStringOperatingSystemType;
use App\Models\AgentStringOperatingSystemVersionType;
use App\Models\Enum\AgentStringDeviceSubTypesEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use WhichBrowser\Parser;

class AgentStringParsingLibrary
{
    public function updateAll(int $minutesBack = 15): void
    {
        $this->parseAllAgentStrings($minutesBack);
    }

    /**
     * @param int $minutesBack
     *
     * @throws \Exception
     */
    public function parseAllAgentStrings($minutesBack = 15): void
    {
        $agentStringQuery = AgentString::query()
            ->select('id', 'name')
            ->where('parsed', false)
            ->orderBy('id');

        if ($minutesBack !== 0) {
            $agentStringQuery->where('updated_at', '>', new Carbon('- ' . $minutesBack . ' minute'));
        }

        $agentStrings = $agentStringQuery->get();

        foreach ($agentStrings as $agentString) {
            $this->parseAgentStrings($agentString);
            AgentStringParseJob::dispatch($agentString);
        }
    }

    /**
     * @param AgentString $agentString
     */
    public function parseAgentStrings(AgentString $agentString): void
    {
        Log::info(
            'Parsing agent string',
            [
                'agent_string' => $agentString->name,
            ]
        );

        $browserAgentInfo = new Parser($agentString->name);

        $this->setDeviceBrowser($agentString, $browserAgentInfo);
        $this->setDeviceBrowserEngine($agentString, $browserAgentInfo);
        $this->setDeviceManufacturer($agentString, $browserAgentInfo);
        $this->setDeviceModel($agentString, $browserAgentInfo);
        $this->setOperatingSystem($agentString, $browserAgentInfo);
        $this->setDeviceType($agentString, $browserAgentInfo);

        $this->setDeviceSubType($agentString, $browserAgentInfo);
        $this->setDeviceSubWBType($agentString, $browserAgentInfo);
        $this->setAgentStringExtra($agentString, $browserAgentInfo);

        $agentString->parsed = true;
        $agentString->save();
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setDeviceBrowser(AgentString $agentString, Parser $browserAgentInfo): void
    {
        if (isset($browserAgentInfo->browser->name)) {
            $deviceBrowser = AgentStringDeviceBrowserType::firstOrCreate(
                [
                    'name' => $browserAgentInfo->browser->name,
                    'version' => $browserAgentInfo->browser->version->value ?? '',
                ]
            );

            $agentStringDeviceBrowser = AgentStringDeviceBrowser::query()
                ->where('agent_string_id', $agentString->id)
                ->first();

            if ($agentStringDeviceBrowser) {
                if ($agentStringDeviceBrowser->agent_string_device_browser_type_id !== $deviceBrowser->id) {
                    $agentStringDeviceBrowser->agent_string_device_browser_type_id = $deviceBrowser->id;
                    $agentStringDeviceBrowser->save();
                }
            } else {
                AgentStringDeviceBrowser::create(
                    [
                        'agent_string_id' => $agentString->id,
                        'agent_string_device_browser_type_id' => $deviceBrowser->id,
                    ]
                );
            }
        }
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setDeviceBrowserEngine(AgentString $agentString, Parser $browserAgentInfo): void
    {
        if (isset($browserAgentInfo->engine->name)) {
            $deviceBrowserEngine = AgentStringDeviceBrowserEngineType::firstOrCreate(
                [
                    'name' => $browserAgentInfo->engine->name,
                    'version' => $browserAgentInfo->engine->version->value ?? '',
                ]
            );

            $agentStringDeviceBrowserEngine = AgentStringDeviceBrowserEngine::query()
                ->where('agent_string_id', $agentString->id)
                ->first();

            if ($agentStringDeviceBrowserEngine) {
                if ($agentStringDeviceBrowserEngine->agent_string_device_browser_engine_type_id !== $deviceBrowserEngine->id) {
                    $agentStringDeviceBrowserEngine->agent_string_device_browser_engine_type_id = $deviceBrowserEngine->id;
                    $agentStringDeviceBrowserEngine->save();
                }
            } else {
                AgentStringDeviceBrowserEngine::create(
                    [
                        'agent_string_id' => $agentString->id,
                        'agent_string_device_browser_engine_type_id' => $deviceBrowserEngine->id,
                    ]
                );
            }
        }
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setDeviceManufacturer(AgentString $agentString, Parser $browserAgentInfo): void
    {
        if (isset($browserAgentInfo->device->manufacturer)) {
            $deviceManufacturer = AgentStringDeviceManufacturerType::firstOrCreate(
                [
                    'name' => $browserAgentInfo->device->manufacturer,
                ]
            );

            $agentStringDeviceManufacturer = AgentStringDeviceManufacturer::query()
                ->where('agent_string_id', $agentString->id)
                ->first();

            if ($agentStringDeviceManufacturer) {
                if ($agentStringDeviceManufacturer->agent_string_device_manufacturer_type_id !== $deviceManufacturer->id) {
                    $agentStringDeviceManufacturer->agent_string_device_manufacturer_type_id = $deviceManufacturer->id;
                    $agentStringDeviceManufacturer->save();
                }
            } else {
                AgentStringDeviceManufacturer::create(
                    [
                        'agent_string_id' => $agentString->id,
                        'agent_string_device_manufacturer_type_id' => $deviceManufacturer->id,
                    ]
                );
            }
        }
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setDeviceModel(AgentString $agentString, Parser $browserAgentInfo): void
    {
        if (isset($browserAgentInfo->device->model)) {
            $deviceModel = AgentStringDeviceModelType::query()
                ->where('name', $browserAgentInfo->device->model)
                ->where('identifier', $browserAgentInfo->device->identifier ?? '')
                ->where('version', $browserAgentInfo->device->series ?? 1)
                ->first();

            if (!($deviceModel instanceof AgentStringDeviceModelType)) {
                $deviceModel = AgentStringDeviceModelType::create(
                    [
                        'name' => $browserAgentInfo->device->model,
                        'identifier' => $browserAgentInfo->device->identifier ?? '',
                        'version' => $browserAgentInfo->device->series ?? 1,
                        'url' => '',
                    ]
                );
            }

            $agentStringDeviceModel = AgentStringDeviceModel::query()
                ->where('agent_string_id', $agentString->id)
                ->first();

            if ($agentStringDeviceModel) {
                if ($agentStringDeviceModel->agent_string_device_model_type_id !== $deviceModel->id) {
                    $agentStringDeviceModel->agent_string_device_model_type_id = $deviceModel->id;
                    $agentStringDeviceModel->save();
                }
            } else {
                AgentStringDeviceModel::create(
                    [
                        'agent_string_id' => $agentString->id,
                        'agent_string_device_model_type_id' => $deviceModel->id,
                    ]
                );
            }
        }
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setOperatingSystem(AgentString $agentString, Parser $browserAgentInfo): void
    {
        if (isset($browserAgentInfo->os->name)) {
            $operatingSystem = AgentStringOperatingSystemType::firstOrCreate(
                [
                    'name' => $browserAgentInfo->os->name,
                ]
            );

            $operatingSystemVersion = AgentStringOperatingSystemVersionType::firstOrCreate(
                [
                    'agent_string_operating_system_type_id' => $operatingSystem->id,
                    'name' => trim($browserAgentInfo->os->version->value ?? ''),
                ]
            );

            $agentStringOperatingSystem = AgentStringOperatingSystem::query()
                ->where('agent_string_id', $agentString->id)
                ->first();

            if ($agentStringOperatingSystem) {
                if (
                    $agentStringOperatingSystem->agent_string_operating_system_type_id !== $operatingSystem->id ||
                    $agentStringOperatingSystem->agent_string_operating_system_version_type_id !== $operatingSystemVersion->id
                ) {
                    $agentStringOperatingSystem->agent_string_operating_system_type_id = $operatingSystem->id;
                    $agentStringOperatingSystem->agent_string_operating_system_version_type_id = $operatingSystemVersion->id;
                    $agentStringOperatingSystem->save();
                }
            } else {
                AgentStringOperatingSystem::create(
                    [
                        'agent_string_id' => $agentString->id,
                        'agent_string_operating_system_type_id' => $operatingSystem->id,
                        'agent_string_operating_system_version_type_id' => $operatingSystemVersion->id,
                    ]
                );
            }
        }
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setDeviceType(AgentString $agentString, Parser $browserAgentInfo): void
    {
        if (
            isset($browserAgentInfo->device->type) &&
            $browserAgentInfo->device->type !== ''
        ) {
            $deviceType = AgentStringDeviceType::firstOrCreate(
                [
                    'name' => $browserAgentInfo->device->type,
                ]
            );

            $agentStringDeviceType = AgentStringDevice::query()
                ->where('agent_string_id', $agentString->id)
                ->first();

            if ($agentStringDeviceType) {
                if ($agentStringDeviceType->agent_string_device_type_id !== $deviceType->id) {
                    $agentStringDeviceType->agent_string_device_type_id = $deviceType->id;
                    $agentStringDeviceType->save();
                }
            } else {
                AgentStringDevice::create(
                    [
                        'agent_string_id' => $agentString->id,
                        'agent_string_device_type_id' => $deviceType->id,
                    ]
                );
            }
        }
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setDeviceSubType(AgentString $agentString, Parser $browserAgentInfo): void
    {
        $deviceSubTypeId = AgentStringDeviceSubTypesEnum::UNKNOWN_ID;

        if ($browserAgentInfo->isMobile()) {
            if (
                $browserAgentInfo->device->subtype === 'smart' ||
                (
                    isset($browserAgentInfo->os->name) &&
                    $browserAgentInfo->os->name === 'Android'
                )
            ) {
                $deviceSubTypeId = AgentStringDeviceSubTypesEnum::SMART_PHONE_ID;
            } elseif ($browserAgentInfo->device->subtype === 'feature') {
                $deviceSubTypeId = AgentStringDeviceSubTypesEnum::FEATURE_PHONE_ID;
            }
        } elseif ($browserAgentInfo->getType() === 'desktop') {
            $deviceSubTypeId = AgentStringDeviceSubTypesEnum::PC_ID;
        }

        $agentStringDeviceSub = AgentStringDeviceSub::query()
            ->where('agent_string_id', $agentString->id)
            ->first();

        if ($agentStringDeviceSub) {
            if ($agentStringDeviceSub->agent_string_device_sub_type_id !== $deviceSubTypeId) {
                $agentStringDeviceSub->agent_string_device_sub_type_id = $deviceSubTypeId;
                $agentStringDeviceSub->save();
            }
        } else {
            AgentStringDeviceSub::create(
                [
                    'agent_string_id' => $agentString->id,
                    'agent_string_device_sub_type_id' => $deviceSubTypeId,
                ]
            );
        }
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setDeviceSubWBType(AgentString $agentString, Parser $browserAgentInfo): void
    {
        if (
            isset($browserAgentInfo->device->subtype) &&
            $browserAgentInfo->device->subtype !== ''
        ) {
            $deviceSubWbType = AgentStringDeviceSubWbType::firstOrCreate(
                [
                    'name' => $browserAgentInfo->device->subtype,
                ]
            );

            $agentStringDeviceSubWb = AgentStringDeviceSubWb::query()
                ->where('agent_string_id', $agentString->id)
                ->first();

            if ($agentStringDeviceSubWb instanceof AgentStringDeviceSubWb) {
                if ($agentStringDeviceSubWb->agent_string_device_sub_wb_type_id !== $deviceSubWbType->id) {
                    $agentStringDeviceSubWb->agent_string_device_sub_wb_type_id = $deviceSubWbType->id;
                    $agentStringDeviceSubWb->save();
                }
            } else {
                AgentStringDeviceSubWbType::create(
                    [
                        'agent_string_id' => $agentString->id,
                        'agent_string_device_sub_wb_type_id' => $deviceSubWbType->id,
                    ]
                );
            }
        }
    }

    /**
     * @param AgentString $agentString
     * @param Parser $browserAgentInfo
     */
    private function setAgentStringExtra(AgentString $agentString, Parser $browserAgentInfo): void
    {
        $deviceInfo = [
            'isBrowser' => $browserAgentInfo->isBrowser(),
            'isMobile' => $browserAgentInfo->isMobile(),
            'isDetected' => $browserAgentInfo->isDetected(),
            'device_manufacturer' => $browserAgentInfo->device->manufacturer ?? '',
            'device_model' => $browserAgentInfo->device->model ?? '',
            'device_identifier' => $browserAgentInfo->device->identifier ?? '',
            'device_type' => $browserAgentInfo->device->type ?? '',
            'model_info' => [
                'type' => $browserAgentInfo->device->type ?? '',
                'subtype' => $browserAgentInfo->device->subtype ?? '',
                'model' => $browserAgentInfo->device->model ?? '',
            ],
            'os' => $browserAgentInfo->os->name ?? '',
            'os_version' => $browserAgentInfo->os->version->value ?? '',
            'engine' => $browserAgentInfo->engine->name ?? '',
            'engine_version' => $browserAgentInfo->engine->version->value ?? '',
            'browser' => $browserAgentInfo->browser->name ?? '',
            'browser_version' => $browserAgentInfo->browser->version->value ?? '',
            'all' => $browserAgentInfo->toArray(),
            'human' => $browserAgentInfo->toString(),
        ];

        $agentStringExtra = AgentStringExtra::query()
            ->where('agent_string_id', $agentString->id)
            ->first();

        if ($agentStringExtra) {
            $agentStringExtra->data_json = $deviceInfo;
            $agentStringExtra->save();
        } else {
            AgentStringExtra::create(
                [
                    'agent_string_id' => $agentString->id,
                    'data_json' => $deviceInfo,
                ]
            );
        }
    }
}
