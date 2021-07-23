<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Response;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Di\DiInterface;

class ResponseProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container): void
    {
        $container->setShared(
            'response',
            function () {
                $response = new Response();

                $response
                    ->setStatusCode(200)
                    ->setContentType('application/vnd.api+json', 'UTF-8')
                ;

                return $response;
            }
        );
    }
}
