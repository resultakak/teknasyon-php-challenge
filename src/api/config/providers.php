<?php

declare(strict_types=1);

use Api\Providers\ConfigProvider;
use Api\Providers\DatabaseProvider;
use Api\Providers\RequestProvider;
use Api\Providers\ResponseProvider;
use Api\Providers\RouterProvider;

return [
    ConfigProvider::class,
    DatabaseProvider::class,
    RequestProvider::class,
    ResponseProvider::class,
    RouterProvider::class,
];
