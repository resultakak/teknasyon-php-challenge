<?php

declare(strict_types=1);

namespace App\Bootstrap;

use Phalcon\Cli\Console;
use Phalcon\Di\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Micro;
use function microtime;

abstract class AbstractBootstrap
{

    protected $application;

    protected $container;

    protected $options = [];

    protected $providers = [];

    public function getApplication()
    {
        return $this->application;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getResponse()
    {
        return $this->container->getShared('response');
    }

    abstract public function run();

    public function setup()
    {
        $this->container->set('metrics', microtime(true));
        $this->setupApplication();
        $this->registerServices();
    }

    protected function setupApplication()
    {
        $this->application = new Micro($this->container);
        $this->container->setShared('application', $this->application);
    }

    private function registerServices()
    {
        /** @var ServiceProviderInterface $provider */
        foreach ($this->providers as $provider) {
            (new $provider())->register($this->container);
        }
    }
}
