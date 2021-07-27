<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;

class Applications extends Model
{
    public function initialize()
    {
        $this->setSource('apps');
    }
}
