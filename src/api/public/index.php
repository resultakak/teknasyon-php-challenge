<?php

declare(strict_types=1);

error_reporting(E_ALL);

use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Session\Adapter\Redis;
use Phalcon\Session\Manager;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = new FactoryDefault();

$container->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => $_ENV['DB_HOST'] ?? null,
                'username' => $_ENV['DB_USERNAME'] ?? null,
                'password' => $_ENV['DB_PASSWORD'] ?? null,
                'dbname'   => $_ENV['DB_DATABASE'] ?? null,
                'options'  => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                    PDO::ATTR_CASE               => PDO::CASE_LOWER,
                ]
            ]
        );
    }
);

$container->set(
    'session',
    function () {
        $options = [
            'host'     => $_ENV['REDIS_HOST'] ?? null,
            'port'     => $_ENV['REDIS_PORT'] ?? 6379,
            'index'    => '1',
            'lifetime' => 3600
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

$container->set(
    'modelsCache',
    function () {
        $serializerFactory = new SerializerFactory();

        $options = [
            'defaultSerializer' => 'Json',
            'lifetime'          => 7200,
            'host'              => $_ENV['REDIS_HOST'] ?? null,
            'port'              => $_ENV['REDIS_PORT'] ?? 6379,
            'index'             => 2,
        ];

        $adapter = new Redis($serializerFactory, $options);

        return new Cache($adapter);
    }
);

$app = new Micro($container);

$app->get('/', function () {
    echo 'OK';
});

$app->post('/register', function () use ($app) {
});

$app->post('/purchase', function () {

});

$app->post('/checkSubscription', function () {

});

$app->handle($_SERVER["REQUEST_URI"]);
