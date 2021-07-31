<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength;

class DeviceApps extends Model
{
    /**
     * @var int|null $daid
     */
    public ?int $daid;

    /**
     * @var integer $did
     */
    public int $did;

    /**
     * @var integer $aid
     */
    public int $aid;

    /**
     * @var string $token
     */
    public string $token;

    /**
     * @var string|null $created
     */
    public ?string $created;

    public function initialize(): void
    {
        $this->setSource('device_apps');

        $this->belongsTo(
            'did',
            Devices::class,
            'did',
            [
                'reusable' => true,
                'alias'    => 'device'
            ]
        );
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            [
                "did",
                "aid",
                "token",
            ],
            new StringLength(
                [
                    "max"             => [
                        "did"   => 20,
                        "aid"   => 20,
                        "token" => 70,
                    ],
                    "min"             => [
                        "did"   => 1,
                        "aid"   => 1,
                        "token" => 30,
                    ],
                    "messageMaximum"  => [
                        "did"   => "Uid too long",
                        "aid"   => "AppID too long",
                        "token" => "Internal Server Error",
                    ],
                    "messageMinimum"  => [
                        "did"   => "Uid too short",
                        "aid"   => "AppID too short",
                        "token" => "Internal Server Error",
                    ],
                    "includedMaximum" => [
                        "did"   => false,
                        "aid"   => false,
                        "token" => false,
                    ],
                    "includedMinimum" => [
                        "did"   => false,
                        "aid"   => false,
                        "token" => false,
                    ]
                ]
            )
        );

        return $this->validate($validator);
    }
}
