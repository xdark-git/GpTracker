<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use RuntimeException;

class ServiceLocator
{
    private static $container;

    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }

    public static function get(string $serviceName)
    {
        if (!isset(self::$container)) {
            throw new RuntimeException('Service locator container not set.');
        }

        return self::$container->get($serviceName);
    }
}
