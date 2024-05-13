<?php

namespace App\Log;

use Monolog\Logger;
use Psr\Log\AbstractLogger;
use DateTimeZone;

class AppLogger extends AbstractLogger
{
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        parent::log($level, $message, $context);
    }
}
