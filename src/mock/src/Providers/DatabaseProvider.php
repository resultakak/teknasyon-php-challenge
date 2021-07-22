<?php

declare(strict_types=1);

namespace App\Providers;

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
        $container->setShared(
            'db',
            function () {
                $options = [
                    'host'     => getenv('DB_HOST'),
                    'username' => getenv('DB_USERNAME'),
                    'password' => getenv('DB_PASSWORD'),
                    'dbname'   => getenv('DB_DATABASE'),
                    'options'  => [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                        PDO::ATTR_CASE               => PDO::CASE_LOWER,
                    ]
                ];

                $connection = new Mysql($options);

                $connection->execute('SET NAMES utf8mb4', []);

                return $connection;
            }
        );
    }
}
