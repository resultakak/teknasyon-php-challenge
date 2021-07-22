<?php

declare(strict_types=1);

return [
    'app'        => [
        'version'      => getenv('VERSION'),
        'timezone'     => getenv('APP_TIMEZONE'),
        'debug'        => getenv('APP_DEBUG', false),
        'env'          => getenv('APP_ENV'),
        'baseUri'      => getenv('APP_BASE_URI'),
        'time'         => microtime(true),
    ],
];
