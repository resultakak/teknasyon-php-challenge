<?php

declare(strict_types=1);

namespace App\Providers;

use Phalcon\Cache;
use Phalcon\Cache\Adapter\Redis;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Storage\SerializerFactory;

class CacheDataProvider implements ServiceProviderInterface
{

    public function register(DiInterface $container): void
    {
        $container->setShared(
            'cache',
            function () {
                $serializerFactory = new SerializerFactory();

                $options = [
                    'defaultSerializer' => 'Json',
                    'lifetime'          => 7200,
                    'host'              => \getenv('REDIS_HOST'),
                    'port'              => \getenv('REDIS_PORT'),
                    'index'             => 1,
                ];

                $adapter = new Redis($serializerFactory, $options);

                return new Cache($adapter);
            }
        );
    }
}
