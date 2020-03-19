<?php

namespace App\Models\Enum\Queue;

class QueueNameEnums
{
    public const HIGH = 'high';
    public const EMAILS = 'emails';
    public const SMS = 'SMS';
    public const DEFAULT = 'default';

    public const LONG_RUNNING_QUEUE = 'long-running-queue';

    public const QUEUE_ARRAY = [
        self::HIGH,
        self::SMS,
        self::EMAILS,
        self::DEFAULT,
    ];

    public const LONG_RUNNING_QUEUE_ARRAY = [
        self::LONG_RUNNING_QUEUE,
    ];
}
