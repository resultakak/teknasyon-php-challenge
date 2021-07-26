<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Http\Response;
use Phalcon\Mvc\Controller;

class DefaultController extends Controller
{
    public function index()
    {
        return "🚀 &nbsp; OK";
    }
}
