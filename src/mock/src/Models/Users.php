<?php

declare(strict_types=1);

namespace App\Models;

use Phalcon\Filter;
use Phalcon\Mvc\Model;

class Users extends Model
{

    public function initialize()
    {
        $this->setSource('credentials');
    }
}
