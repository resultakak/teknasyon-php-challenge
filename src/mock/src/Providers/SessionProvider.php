<?php

declare(strict_types=1);

namespace App\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

use Phalcon\Session\Manager;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Session\Adapter\Redis;

class SessionProvider implements ServiceProviderInterface
{
    public function register(DiInterface $container): void
    {
        $container->setShared(
            'session',
            function () {
                $options = [
                    'uniqueId' => 'mock',
                    'host'     => getenv('REDIS_HOST'),
                    'port'     => getenv('REDIS_PORT'),
                    'index'    => "1"
                ];

                $session           = new Manager();
                $serializerFactory = new SerializerFactory();
                $factory           = new AdapterFactory($serializerFactory);
                $redis             = new Redis($factory, $options);

                $session
                    ->setAdapter($redis)
                    ->start();

                return $session;
            }
        );
    }
}
