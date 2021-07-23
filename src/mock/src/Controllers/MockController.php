<?php

declare(strict_types = 1);

namespace App\Controllers;

use Phalcon\Mvc\Controller;

class MockController extends Controller
{

    public function ios()
    {
        $this->_handle();
    }

    public function android()
    {
        $this->_handle();
    }

    protected function _handle()
    {
        $receipt = $this->request->getReceiptHash();

        $receipt = $this->receipt->validation($receipt);

        if (!isset($receipt) || empty($receipt)) {
            return $this->response
                ->setPayloadError('Invalid Receipt Token')
                ->setStatusCode($this->response::BAD_REQUEST);
        }

        $data = ['receipt' => $receipt];

        return $this->response
            ->setPayloadSuccess(['data' => $data])
            ->setStatusCode($this->response::OK);
    }
}
