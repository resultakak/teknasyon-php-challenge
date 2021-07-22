<?php

declare(strict_types = 1);

use App\Providers\CacheDataProvider;
use App\Providers\ConfigProvider;
use App\Providers\DatabaseProvider;
use App\Providers\ErrorHandlerProvider;
use App\Providers\LoggerProvider;
use App\Providers\RouterProvider;
use App\Providers\SessionProvider;

return [
    CacheDataProvider::class,
    ConfigProvider::class,
    DatabaseProvider::class,
    ErrorHandlerProvider::class,
    LoggerProvider::class,
    RouterProvider::class,
    SessionProvider::class,
];
