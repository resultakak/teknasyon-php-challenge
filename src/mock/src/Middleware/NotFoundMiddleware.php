<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\Messages;
use Phalcon\Di\Injectable;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class NotFoundMiddleware extends Injectable implements MiddlewareInterface
{

    public function beforeNotFound()
    {
        $this->application
            ->response
            ->setStatusCode(404, Messages::NOT_FOUND)
            ->sendHeaders()
            ->setContent(Messages::NOT_FOUND)
            ->send();

        return false;
    }

    public function call(Micro $api)
    {
        return true;
    }
}
