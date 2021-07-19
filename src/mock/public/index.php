<?php

declare(strict_types=1);

error_reporting(E_ALL);

use Phalcon\Di\FactoryDefault;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = new FactoryDefault();

$app = new Micro($container);

$app->get('/', function () {
    echo 'OK';
});

$app->handle($_SERVER["REQUEST_URI"]);
