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
        $config = $container->getShared('config');

        $container->setShared(
            'cache',
            function () use ($config) {
                $options = $config->get('cache')->toArray();

                $serializerFactory = new SerializerFactory();

                $adapter = new Redis($serializerFactory, $options);

                return new Cache($adapter);
            }
        );
    }
}
