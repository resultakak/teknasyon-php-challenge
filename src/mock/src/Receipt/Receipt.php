<?php

namespace App\Receipt;

use Phalcon\Filter\FilterFactory;

class Receipt
{
    public $locator;

    public function __construct()
    {
        $factory = new FilterFactory();
        $this->locator = $factory->newInstance();
    }

    public function verify($receipt)
    {
        $receipt = $this->validation($receipt);

        if (true === $receipt) {
            return $receipt;
        }

        return false;
    }

    public function validation($receipt)
    {
        if (empty($receipt) || ! isset($receipt)) {
            return false;
        }

        return $this->locator->sanitize($receipt, 'string');
    }
}
