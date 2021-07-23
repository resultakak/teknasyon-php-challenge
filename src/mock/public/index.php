<?php

declare(strict_types=1);

error_reporting(E_ALL);

use App\Bootstrap\Api;

define('BASE_PATH', dirname(__DIR__));

require_once __DIR__ . '/../src/Core/autoload.php';

$app = new Api();

$app->setup();

$app->run();
