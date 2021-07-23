<?php

declare(strict_types = 1);

use App\Providers\ConfigProvider;
use App\Providers\LoggerProvider;
use App\Providers\ErrorHandlerProvider;
use App\Providers\DatabaseProvider;
use App\Providers\RequestProvider;
use App\Providers\ResponseProvider;
use App\Providers\RouterProvider;
use App\Providers\CacheDataProvider;
use App\Providers\SessionProvider;
use App\Providers\ReceiptProvider;

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
    ReceiptProvider::class,
];
