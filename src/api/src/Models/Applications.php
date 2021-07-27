<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;

class Applications extends Model
{

    public $id;
    public $app_id;
    public $name;
    public $created;

    public function initialize()
    {
        $this->setSource('apps');
    }
}
