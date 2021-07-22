<?php

namespace App\Core;

use function function_exists;

if (true !== function_exists('App\Core\appPath')) {
    function appPath(string $path = ''): string
    {
        return dirname(dirname(__DIR__)) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
