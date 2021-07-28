<?php

declare(strict_types=1);

use Api\Providers\CacheDataProvider;
use Api\Providers\ConfigProvider;
use Api\Providers\DatabaseProvider;
use Api\Providers\ErrorHandlerProvider;
use Api\Providers\LoggerProvider;
use Api\Providers\RequestProvider;
use Api\Providers\ResponseProvider;
use Api\Providers\RouterProvider;
use Api\Providers\SessionProvider;
use Api\Providers\MockProvider;

return [
    ConfigProvider::class,
    LoggerProvider::class,
    //ErrorHandlerProvider::class,
    DatabaseProvider::class,
    RequestProvider::class,
    ResponseProvider::class,
    RouterProvider::class,
    CacheDataProvider::class,
    SessionProvider::class,
    MockProvider::class
];
