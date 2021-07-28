<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength;

/**
 * Class Devices
 *
 * @method void setSource(string)
 * @method void addBehavior()
 */
class Devices extends Model
{
    /**
     * @var string $uid
     */
    public $uid;

    /**
     * @var string $app_id
     */
    public $app_id;

    /**
     * @var string $language
     */
    public $language;

    /**
     * @var string $token
     */
    public $token;

    /**
     * @var string $created
     */
    public $created;

    public function initialize(): void
    {
        $this->setSource('devices');

        $this->addBehavior(
            new Timestampable(
                [
                    'onCreate' => [
                        'field'  => 'created',
                        'format' => 'Y-m-d H:i:s',
                    ],
                ]
            )
        );
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            [
                "uid",
                "app_id",
                "language",
                "os",
                "token",
            ],
            new StringLength(
                [
                    "max"             => [
                        "uid"      => 60,
                        "app_id"   => 60,
                        "language" => 10,
                        "os"       => 30,
                        "token"    => 35,
                    ],
                    "min"             => [
                        "uid"      => 20,
                        "app_id"   => 20,
                        "language" => 1,
                        "os"       => 3,
                        "token"    => 30,
                    ],
                    "messageMaximum"  => [
                        "uid"      => "Uid too long",
                        "app_id"   => "AppID too long",
                        "language" => "Language code too long",
                        "os"       => "OS name too long",
                        "token"    => "Internal Server Error",
                    ],
                    "messageMinimum"  => [
                        "uid"      => "Uid too short",
                        "app_id"   => "AppID too short",
                        "language" => "Language code too short",
                        "os"       => "OS name too short",
                        "token"    => "Internal Server Error",
                    ],
                    "includedMaximum" => [
                        "uid"      => false,
                        "app_id"   => true,
                        "language" => false,
                        "os"       => false,
                        "token"    => false,
                    ],
                    "includedMinimum" => [
                        "uid"      => false,
                        "app_id"   => true,
                        "language" => false,
                        "os"       => false,
                        "token"    => false,
                    ]
                ]
            )
        );

        return $this->validate($validator);
    }
}
