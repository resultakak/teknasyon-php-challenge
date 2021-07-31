<?php

declare(strict_types=1);

namespace Api\Bootstrap;

use Phalcon\Di\FactoryDefault;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\Micro;

use function microtime;

abstract class AbstractBootstrap
{
    /**
     * @var Micro $application
     */
    protected $application;

    /*
     * @var FactoryDefault $container;
     */
    protected $container;

    /**
     * @var array $options
     */
    protected array $options = [];

    /**
     * @var array $providers
     */
    protected array $providers = [];

    /**
     * @return Micro
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->container->getShared('response');
    }

    /**
     * @return mixed
     */
    abstract public function run();

    /**
     * @return void
     */
    public function setup()
    {
        $this->container->set('metrics', microtime(true));
        $this->setupApplication();
        $this->registerServices();
    }

    protected function setupApplication(): void
    {
        $this->application = new Micro($this->container);
        $this->container->setShared('application', $this->application);
    }

    private function registerServices(): void
    {
        /** @var ServiceProviderInterface $provider */
        foreach ($this->providers as $provider) {
            (new $provider())->register($this->container);
        }
    }
}
