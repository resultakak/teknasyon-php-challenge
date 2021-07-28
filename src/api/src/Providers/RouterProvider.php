<?php

declare(strict_types=1);

namespace Api\Providers;

use Api\Controllers\ApiController;
use Api\Controllers\DefaultController;
use Api\Middleware\NotFoundMiddleware;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;

class RouterProvider implements ServiceProviderInterface
{
    public function register(DiInterface $container): void
    {
        $application = $container->getShared('application');
        $eventsManager = $container->getShared('eventsManager');
        $this->attachRoutes($application);
        $this->attachMiddleware($application, $eventsManager);
        $application->setEventsManager($eventsManager);
    }

    private function attachRoutes(Micro $application)
    {
        $home = new Collection();
        $home
            ->setHandler(new DefaultController())
            ->get('/', 'index');
        $application->mount($home);

        $api = new Collection();
        $api
            ->setHandler(new ApiController())
            ->setPrefix('/api')
            ->post('/register', 'register')
            ->post('/purchase', 'purchase')
            ->get('/check_subscription', 'check_subscription');

        $application->mount($api);
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
            NotFoundMiddleware::class => 'before'
        ];
    }
}
