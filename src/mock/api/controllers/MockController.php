<?php

declare(strict_types=1);

namespace App\Api\Controllers;

use Phalcon\Mvc\Controller;

class MockController extends Controller
{

    public function ios()
    {
        return '/ios/receipt/verify';
    }

    public function android()
    {
        return '/android/receipt/verify';
    }
}
