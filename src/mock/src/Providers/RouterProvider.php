<?php

declare(strict_types=1);

namespace App\Providers;

use App\Api\Controllers\MockController;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\NotFoundMiddleware;
use App\Middleware\ResponseMiddleware;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;

class RouterProvider implements ServiceProviderInterface
{

    public function register(DiInterface $container): void
    {
        $application   = $container->getShared('application');
        $eventsManager = $container->getShared('eventsManager');

        $this->attachRoutes($application);
        $this->attachMiddleware($application, $eventsManager);
        $application->setEventsManager($eventsManager);
    }

    private function attachRoutes(Micro $application)
    {
        $mocks = new Collection();
        $mocks
            ->setHandler(new MockController())
            ->setPrefix('/api')
            ->post('/ios/receipt/verify', 'ios')
            ->post('/android/receipt/verify', 'android')
        ;

        $application->mount($mocks);
    }

    private function attachMiddleware(Micro $application, Manager $eventsManager)
    {
        $middleware = $this->getMiddleware();

        foreach ($middleware as $class => $function) {
            $eventsManager->attach('micro', new $class());
            $application->{$function}(new $class());
        }
    }

    private function getMiddleware(): array
    {
        return [
            NotFoundMiddleware::class       => 'before',
            AuthenticationMiddleware::class => 'before',
            ResponseMiddleware::class       => 'after',
        ];
    }
}
