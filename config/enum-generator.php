<?php

return [
    'default-leave-schema' => false,
    'enumPath' => app_path() . '/Models/Enum',
    'tables' => [
        'agent_strings.agent_string_device_browser_engine_types' => [
            'uuid' => true,
//            'leave-schema' => true,
//            'prepend' => 'AGENT',
        ],
        'agent_strings.agent_string_device_browser_types' => [
            'uuid' => true,
        ],
        'agent_strings.agent_string_device_manufacturer_types' => [
            'uuid' => true,
        ],
        'agent_strings.agent_string_device_model_types' => [
            'uuid' => true,
        ],
        'agent_strings.agent_string_device_sub_types' => [
            'uuid' => true,
        ],
        'agent_strings.agent_string_device_sub_wb_types' => [
            'uuid' => true,
        ],
        'agent_strings.agent_string_device_types' => [
            'uuid' => true,
        ],
        'agent_strings.agent_string_operating_system_types' => [
            'uuid' => true,
        ],
        'agent_strings.agent_string_operating_system_version_types' => [
            'uuid' => true,
        ],
        'files.file_types' => [
            'uuid' => true,
        ],
        'files.file_storage_types' => [
            'uuid' => true,
        ],
        'files.file_sections' => [
            'uuid' => true,
        ],
        'users.roles' => [
            'uuid' => false,
//            'prepend_class' => 'Rights',
//            'prepend_name' => 'Rights',
        ],
        'users.permissions' => [
            'uuid' => false,
//            'prepend_class' => 'Rights',
//            'prepend_name' => 'Rights',
        ],
//        'tags.tags' => [
//            'public.uuid' => true,
//        ],
    ],
];
