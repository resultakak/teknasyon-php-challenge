<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength;

class Devices extends Model
{

    public $id;
    public $uid;
    public $app_id;
    public $language;
    public $os;
    public $created;

    public function initialize()
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

        $validator->add([
            "uid",
            "app_id",
            "language",
            "os",
        ], new StringLength([
            "max"             => [
                "uid"      => 60,
                "app_id"   => 60,
                "language" => 10,
                "os"       => 40,
            ],
            "min"             => [
                "uid"      => 20,
                "app_id"   => 20,
                "language" => 1,
                "os"       => 3,
            ],
            "messageMaximum"  => [
                "uid"      => "Uid too long",
                "app_id"   => "AppID too long",
                "language" => "Language code too long",
                "os"       => "OS name too long",
            ],
            "messageMinimum"  => [
                "uid"      => "Uid too short",
                "app_id"   => "AppID too short",
                "language" => "Language code too short",
                "os"       => "OS name too short",
            ],
            "includedMaximum" => [
                "uid"      => false,
                "app_id"   => true,
                "language" => false,
                "os"       => false,
            ],
            "includedMinimum" => [
                "uid"      => false,
                "app_id"   => true,
                "language" => false,
                "os"       => false,
            ]
        ]));

        return $this->validate($validator);
    }
}
