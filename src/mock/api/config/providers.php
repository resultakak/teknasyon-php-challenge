<?php

declare(strict_types=1);

use App\Providers\CacheDataProvider;
use App\Providers\DatabaseProvider;
use App\Providers\RouterProvider;
use App\Providers\SessionProvider;

return [
    DatabaseProvider::class,
    RouterProvider::class,
    CacheDataProvider::class,
    SessionProvider::class,
];
