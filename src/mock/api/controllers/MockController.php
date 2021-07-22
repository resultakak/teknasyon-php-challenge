<?php

declare(strict_types=1);

namespace App\Api\Controllers;

use Phalcon\Mvc\Controller;

class MockController extends Controller
{

    public function ios()
    {
        return 'iOS!!!';
    }
    public function android()
    {
        return 'Android!!!';
    }
}
