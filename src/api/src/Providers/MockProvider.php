<?php

declare(strict_types=1);

namespace Api\Providers;

use Api\Mock\Mock;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Di\DiInterface;

class MockProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container): void
    {
        $config = $container->getShared('config');

        $container->set('mock', function () use ($config) {
            $options = $config->get('mock')->toArray();

            $mock = new Mock($options);

            return $mock;
        });
    }
}
