<?php

namespace App\Logging;

use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;

class GelfLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array $config
     *
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $handler = new GelfHandler(new Publisher(new UdpTransport($config['host'], $config['port'])));
        return new Logger('main', [$handler]);
    }
}
