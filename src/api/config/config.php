<?php

declare(strict_types=1);

use function Api\Core\envValue;

return [
    'app'     => [
        'version'      => envValue('VERSION', time()),
        'timezone'     => envValue('APP_TIMEZONE', 'UTC'),
        'debug'        => envValue('APP_DEBUG', false),
        'env'          => envValue('APP_ENV', 'development'),
        'devMode'      => true,
        'baseUri'      => envValue('APP_BASE_URI'),
        'supportEmail' => envValue('APP_SUPPORT_EMAIL'),
        'time'         => microtime(true),
    ],
    'db'      => [
        'host'     => getenv('DB_HOST'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname'   => getenv('DB_DATABASE')
    ],
    'cache'   => [
        'prefix'            => 'apic_',
        'defaultSerializer' => 'Json',
        'lifetime'          => 7200,
        'host'              => getenv('REDIS_HOST'),
        'port'              => getenv('REDIS_PORT'),
        'index'             => 1,
    ],
    'session' => [
        'prefix'            => 'apis_',
        'defaultSerializer' => 'Json',
        'lifetime'          => 7200,
        'host'              => getenv('REDIS_HOST'),
        'port'              => getenv('REDIS_PORT'),
        'index'             => 2
    ],
    'mock' => [
        'url' => 'http://t-mock.resul.me/api/{platform}/receipt/verify'
    ]
];
