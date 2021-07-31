<?php

namespace App\Core;

use function function_exists;

if (true !== function_exists('App\Core\appPath')) {
    function appPath(string $path = ''): string
    {
        return dirname(__DIR__, 2). ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (true !== function_exists('App\Core\envValue')) {
    function envValue(string $variable, $default = null)
    {
        $return = $default;
        $value  = getenv($variable);
        $values = [
            'false' => false,
            'true'  => true,
            'null'  => null,
        ];

        if (false !== $value) {
            $return = $values[$value] ?? $value;
        }

        return $return;
    }
}
