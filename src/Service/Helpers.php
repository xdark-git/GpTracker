<?php

namespace App\Service;

class Helpers
{
    public static function arrayGet(array $array, $key, $default = null): mixed
    {
        if (array_key_exists($key, $array) && isset($array[$key])) {
            return $array[$key];
        }

        return $default;
    }
}