<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Http\Response;
use Phalcon\Mvc\Controller;

class ApiController extends Controller
{
    public function register(): Response
    {
        return $this->response
            ->setPayloadSuccess(['data' => $this->request->getJsonRawBody()])
            ->setStatusCode($this->response::OK);
    }

    public function purchase(): Response
    {
        return $this->response
            ->setPayloadSuccess(['data' => 'purchase'])
            ->setStatusCode($this->response::OK);
    }

    public function check_subscription(): Response
    {
        return $this->response
            ->setPayloadSuccess(['data' => 'check_subscription'])
            ->setStatusCode($this->response::OK);
    }
}
