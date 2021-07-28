<?php

declare(strict_types=1);

namespace Api\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Session\Adapter\Redis;
use Phalcon\Session\Manager;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

class SessionProvider implements ServiceProviderInterface
{
    public function register(DiInterface $container): void
    {
        $config = $container->getShared('config');

        $container->setShared('session', function () use ($config) {
            $options = $config->get('session')->toArray();

            $session = new Manager();
            $serializerFactory = new SerializerFactory();
            $factory = new AdapterFactory($serializerFactory);
            $redis = new Redis($factory, $options);

            $session->setAdapter($redis)->start();

            return $session;
        });
    }
}
