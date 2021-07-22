<?php

declare(strict_types = 1);

use Phalcon\Loader;

use function App\Core\appPath;

require __DIR__.'/functions.php';

$loader = new Loader;
$namespaces = [
    'App\Api\Controllers' => appPath('/api/controllers'),
];

$loader->registerNamespaces($namespaces);
$loader->register();

require appPath('/vendor/autoload.php');
