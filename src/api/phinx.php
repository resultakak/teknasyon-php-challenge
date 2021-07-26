<?php

$env = [
    'adapter' => 'mysql',
    'host'    => getenv('DB_HOST'),
    'name'    => getenv('DB_DATABASE'),
    'user'    => getenv('DB_USERNAME'),
    'pass'    => getenv('DB_PASSWORD'),
    'port'    => '3306',
    'charset' => 'utf8',
];

return [
    'paths'         => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds'      => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments'  => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'development',
        'production'              => $env,
        'development'             => $env,
        'testing'                 => $env
    ],
    'version_order' => 'creation'
];
