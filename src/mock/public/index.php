<?php

declare(strict_types=1);

error_reporting(E_ALL);

use App\Bootstrap\Api;
use Phalcon\Mvc\Micro\Exception;

define('BASE_PATH', dirname(__DIR__));

try {
    require_once __DIR__ . '/../src/Core/autoload.php';

    $app = new Api();

    $app->setup();

    $app->run();

} catch (Exception $ex) {
    echo $ex->getMessage();
}
