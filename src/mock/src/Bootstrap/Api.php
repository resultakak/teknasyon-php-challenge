<?php

declare(strict_types=1);

namespace App\Bootstrap;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;

use function App\Core\appPath;

class Api extends AbstractBootstrap
{
    public function run()
    {
        return $this->application->handle($_SERVER['REQUEST_URI']);
    }

    public function setup()
    {
        $this->container = new FactoryDefault();
        $this->providers = require appPath('config/providers.php');

        parent::setup();
    }
}
