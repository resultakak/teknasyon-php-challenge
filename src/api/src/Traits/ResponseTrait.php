<?php

declare(strict_types=1);

namespace Api\Traits;

use Api\Http\Response;
use Phalcon\Mvc\Micro;

trait ResponseTrait
{
    protected function halt(Micro $api, int $status, string $message)
    {
        /** @var Response $response */
        $response = $api->getService('response');
        $response
            ->setPayloadError($message)
            ->setStatusCode($status)
            ->send();

        $api->stop();
    }
}
