<?php

declare(strict_types=1);

namespace Api\Middleware;

use Api\Traits\ResponseTrait;
use Phalcon\Di\Injectable;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class NotFoundMiddleware extends Injectable implements MiddlewareInterface
{
    use ResponseTrait;

    /**
     * @return bool
     */
    public function beforeNotFound(): bool
    {
        $this->halt(
            $this->application,
            $this->response::NOT_FOUND,
            $this->response->getHttpCodeDescription($this->response::NOT_FOUND)
        );

        return false;
    }

    /**
     * @param Micro $api
     * @return bool
     */
    public function call(Micro $api): bool
    {
        return true;
    }
}
