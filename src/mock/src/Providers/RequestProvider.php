<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Request;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Di\DiInterface;

class RequestProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container): void
    {
        $container->setShared('request', new Request());
    }
}
