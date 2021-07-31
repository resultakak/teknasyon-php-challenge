<?php

/** @noinspection PhpUndefinedClassInspection */

declare(strict_types=1);

namespace Api\Models;

use Phalcon\{Mvc\Model, Validation, Validation\Validator\InclusionIn, Validation\Validator\StringLength};

class Subscriptions extends Model
{
    /**
     * @var integer $sid
     */
    public int $sid;

    /**
     * @var integer $daid
     */
    public int $daid;

    /**
     * @var integer $did
     */
    public int $did;

    /**
     * @var integer $aid
     */
    public int $aid;

    /**
     * @var string $receipt
     */
    public string $receipt;

    /**
     * @var bool $status
     */
    public bool $status;

    /**
     * @var string $expire_date
     */
    public string $expire_date;

    /**
     * @var string $event
     */
    public string $event;

    /**
     * @var string $created
     */
    public string $created;

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

    public function actionHanlde(): void
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

    public function beforeSave(): void
    {
        $this->actionHanlde();
    }

    public function beforeUpdate(): void
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
