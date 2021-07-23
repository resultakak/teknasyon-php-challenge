<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Http\Response;
use App\Traits\ResponseTrait;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class ResponseMiddleware implements MiddlewareInterface
{
    use ResponseTrait;

    public function call(Micro $mock)
    {
        /** @var Response $response */
        $response = $mock->getService('response');
        $response->send();

        return true;
    }
}
