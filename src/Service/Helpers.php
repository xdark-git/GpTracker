<?php

namespace App\Service;

class Helpers
{
    public static function ArrayGet(array $array, $key, $default = null): mixed
    {
        return $array[$key] ?? $default;
    }
}