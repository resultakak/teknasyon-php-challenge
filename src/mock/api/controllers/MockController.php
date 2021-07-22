<?php

declare(strict_types=1);

namespace App\Api\Controllers;

use Phalcon\Mvc\Controller;

class MockController extends Controller
{

    public function ios()
    {
        return $this
            ->response
            ->setJsonContent(['data' => ['/ios/receipt/verify']])
            ->setStatusCode($this->response::CREATED);
    }

    public function android()
    {
        return '/android/receipt/verify';
    }
}
