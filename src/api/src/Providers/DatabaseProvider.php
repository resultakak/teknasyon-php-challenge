<?php

declare(strict_types=1);

namespace Api\Providers;

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class DatabaseProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container): void
    {
        $config = $container->getShared('config');

        $container->setShared(
            'db',
            function () use ($config) {
                $options = $config->get('db')->toArray();

                $connection = new Mysql($options);

                $connection->execute('SET NAMES utf8mb4', []);

                return $connection;
            }
        );
    }
}
