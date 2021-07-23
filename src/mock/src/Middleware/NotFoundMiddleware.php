<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Traits\ResponseTrait;
use Phalcon\Di\Injectable;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class NotFoundMiddleware extends Injectable implements MiddlewareInterface
{
    use ResponseTrait;

    public function beforeNotFound()
    {
        $this->halt(
            $this->application,
            $this->response::NOT_FOUND,
            $this->response->getHttpCodeDescription($this->response::NOT_FOUND)
        );

        return false;
    }

    public function call(Micro $mock)
    {
        return true;
    }
}
