<?php

/** @noinspection PhpUndefinedClassInspection */

declare(strict_types=1);

use Phalcon\Loader;

$loader = new Loader();
$namespaces = [

];
$loader->registerNamespaces($namespaces);
$loader->register();
