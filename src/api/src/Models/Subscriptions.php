<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;

class Subscriptions extends Model
{

    /**
     * @var $device_id
     */
    public $device_id;

    /**
     * @var $receipt
     */
    public $receipt;

    /**
     * @var $status
     */
    public $status;

    /**
     * @var $expire_date
     */
    public $expire_date;

    /**
     * @var $created
     */
    public $created;
}
