<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Constants\Filters;
use Phalcon\Filter;
use Phalcon\Filter\FilterFactory;
use Phalcon\Mvc\Controller;

abstract class AbstractController extends Controller
{

    abstract public function register();
    abstract public function purchase();
    abstract public function check_subscription();

    protected function clean(string $text)
    {
        $text = $this->filter->sanitize($text, [
            Filters::FILTER_STRING,
            Filters::FILTER_TRIM
        ]);

        $text = str_replace([" ", "\n", "\t"], "", $text);

        return $text;
    }
}
