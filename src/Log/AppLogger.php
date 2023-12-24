<?php

namespace App\Log;

use Monolog\Logger;
use DateTimeZone;

class AppLogger extends Logger
{
    public function __construct(
        string $name,
        array $handlers = [],
        array $processors = [],
        DateTimeZone|null $timezone = null
    ) {
        parent::__construct($name, $handlers, $processors, $timezone);
    }
}
