<?php

declare(strict_types=1);

namespace Api\Providers;

use Api\Cache\Manager;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Di\DiInterface;

class CacheManagerProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container): void
    {
        $application = $container->getShared('application');

        $container->setShared('cacheManager', function () use ($application) {
            return new Manager($application);
        });
    }
}
