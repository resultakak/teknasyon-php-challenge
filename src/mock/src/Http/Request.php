<?php

declare(strict_types=1);

namespace App\Http;

use Phalcon\Http\Request as PhRequest;

class Request extends PhRequest
{
    public function getReceiptHash()
    {
        $data = $this->getJsonRawBody();

        return true === isset($data->receipt) ? $data->receipt : false;
    }
}
