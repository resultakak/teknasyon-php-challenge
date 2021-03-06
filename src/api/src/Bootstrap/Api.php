<?php

/** @noinspection PhpUndefinedClassInspection */

declare(strict_types=1);

namespace Api\Bootstrap;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Exception;

use function Api\Core\appPath;

class Api extends AbstractBootstrap
{
    /**
     * @return Micro|void
     *
     */
    public function run()
    {
        try {
            return $this->application->handle($_SERVER['REQUEST_URI']);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @return void
     */
    public function setup()
    {
        $this->container = new FactoryDefault();
        $this->providers = require appPath('config/providers.php');

        parent::setup();
    }
}
