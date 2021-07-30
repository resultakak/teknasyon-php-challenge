<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\StringLength;

class Subscriptions extends Model
{
    /**
     * @var integer $sid
     */
    public $sid;

    /**
     * @var integer $daid
     */
    public $daid;

    /**
     * @var integer $did
     */
    public $did;

    /**
     * @var integer $aid
     */
    public $aid;

    /**
     * @var string $receipt
     */
    public $receipt;

    /**
     * @var bool $status
     */
    public $status;

    /**
     * @var string $expire_date
     */
    public $expire_date;

    /**
     * @var string $event
     */
    public $event;

    /**
     * @var string $created
     */
    public $created;

    public function initialize(): void
    {
        $this->setSource('subscriptions');

        $this->hasOne(
            'aid',
            Applications::class,
            'aid',
            [
                'reusable' => true,
                'alias'    => 'app'
            ]
        );

        $this->hasOne(
            'did',
            Devices::class,
            'did',
            [
                'reusable' => true,
                'alias'    => 'device'
            ]
        );

        $this->hasOne(
            'daid',
            DeviceApps::class,
            'daid',
            [
                'reusable' => true,
                'alias'    => 'deviceApp'
            ]
        );
    }

    public function actionHanlde()
    {
        if (true === $this->status) {
            $this->event = 'started';
        } else {
            $this->event = 'canceled';
        }

        if (true === is_null($this->expire_date)) {
            $this->expire_date = date('Y-m-d H:is', 0);
        }
    }

    public function beforeSave()
    {
        $this->actionHanlde();
    }

    public function beforeUpdate()
    {
        $this->actionHanlde();
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            "event",
            new InclusionIn(
                [
                    "message" => "The event must be: started|renewed|canceled",
                    "domain"  => ["started", "renewed", "canceled"],
                ]
            )
        );

        $validator->add(
            "status",
            new InclusionIn(
                [
                    "message" => "The status must be true or false",
                    "domain"  => [true, false],
                ]
            )
        );

        $validator->add(
            [
                "did",
                "aid",
                "receipt"
            ],
            new StringLength(
                [
                    "max"             => [
                        "did"     => 20,
                        "aid"     => 20,
                        "receipt" => 70,
                    ],
                    "min"             => [
                        "did"     => 1,
                        "aid"     => 1,
                        "receipt" => 20
                    ],
                    "messageMaximum"  => [
                        "did"     => "Internal Server Error: did too long  (1-20)",
                        "aid"     => "Internal Server Error: aid too long  (1-20)",
                        "receipt" => "Receipt too long (20-70)"
                    ],
                    "messageMinimum"  => [
                        "did"     => "Internal Server Error: did too short  (1-20)",
                        "aid"     => "Internal Server Error: aid too short  (1-20)",
                        "receipt" => "Receipt too short (20-70)"
                    ],
                    "includedMaximum" => [
                        "did"     => false,
                        "aid"     => false,
                        "receipt" => false
                    ],
                    "includedMinimum" => [
                        "did"     => false,
                        "aid"     => false,
                        "receipt" => false
                    ]
                ]
            )
        );

        return $this->validate($validator);
    }
}
