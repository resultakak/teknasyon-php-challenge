<?php

namespace Api\Core;

use function function_exists;

if (true !== function_exists('Api\Core\appPath')) {
    /**
     * @param string $path
     * @return string
     */
    function appPath(string $path = ''): string
    {
        return dirname(dirname(__DIR__)) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (true !== function_exists('Api\Core\envValue')) {
    /**
     * @param string $variable
     * @param null   $default
     * @return array|mixed|string|null
     */
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
