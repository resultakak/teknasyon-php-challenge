<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Traits\ResponseTrait;
use DateTime;
use DateTimeZone;
use Phalcon\Exception as HttpException;
use Phalcon\Mvc\Controller;

class MockController extends Controller
{
    use ResponseTrait;

    public function ios()
    {
        $this->_handle();
    }

    protected function _handle()
    {
        try {
            $receipt = $this->request->getReceiptHash();

            $receipt = $this->receipt->validation($receipt);

            if (! isset($receipt) || empty($receipt)) {
                return $this->response
                    ->setPayloadError('Invalid Receipt Token')
                    ->setStatusCode($this->response::BAD_REQUEST);
            }

            $last_char = (int) substr($receipt, -1);

            if (($last_char % 2) == 0) {
                $code = $this->response::ACCEPTED;
                $data = [
                    'status'  => false,
                    'receipt' => $receipt
                ];
            } else {
                $code = $this->response::OK;
                $date = new DateTime("+1 days", new DateTimeZone("-6"));
                $data = [
                    'status'      => true,
                    'receipt'     => $receipt,
                    'expire_date' => $date->format('Y-m-d H:i:s'),
                ];
            }

            return $this->response
                ->setPayloadSuccess(['data' => $data])
                ->setStatusCode($code);
        } catch (HttpException $ex) {
            $this->halt(
                $this->application,
                $ex->getCode(),
                $ex->getMessage()
            );
        }
    }

    public function android()
    {
        $this->_handle();
    }

    public function auth_test()
    {
        try {
            return $this->response
                ->setPayloadSuccess(['message' => "Successfull"])
                ->setStatusCode($this->response::OK);
        } catch (HttpException $ex) {
            $this->halt(
                $this->application,
                $ex->getCode(),
                $ex->getMessage()
            );
        }
    }
}
