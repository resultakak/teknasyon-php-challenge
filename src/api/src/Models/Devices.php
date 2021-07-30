<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;
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
     * @var integer $did
     */
    public $did;

    /**
     * @var string $uid
     */
    public $uid;

    /**
     * @var string $language
     */
    public $language;

    /**
     * @var string $platform
     */
    public $platform;

    /**
     * @var string $created
     */
    public $created;

    public function initialize(): void
    {
        $this->setSource('devices');

        $this->hasMany(
            'did',
            DeviceApps::class,
            'did',
            [
                'reusable' => true,
                'alias'    => 'app'
            ]
        );

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
            "language",
            new InclusionIn(
                [
                    "message" => "The language must be ISO 639-1 Language Code",
                    "domain"  => ["en", "de", "es", "ru", "zh", "tr", "fr", "da", "nl"],
                ]
            )
        );

        $validator->add(
            "platform",
            new InclusionIn(
                [
                    "message" => "The platform must be IOS or ANDROID",
                    "domain"  => ["IOS", "ANDROID"],
                ]
            )
        );

        $validator->add(
            [
                "uid",
                "language",
                "platform"
            ],
            new StringLength(
                [
                    "max"             => [
                        "uid"      => 70,
                        "language" => 3,
                        "platform" => 20,
                    ],
                    "min"             => [
                        "uid"      => 20,
                        "language" => 1,
                        "platform" => 3
                    ],
                    "messageMaximum"  => [
                        "uid"      => "Uid too long",
                        "language" => "Language code too long",
                        "platform" => "OS name too long"
                    ],
                    "messageMinimum"  => [
                        "uid"      => "Uid too short",
                        "language" => "Language code too short",
                        "platform" => "OS name too short"
                    ],
                    "includedMaximum" => [
                        "uid"      => false,
                        "language" => true,
                        "platform" => false
                    ],
                    "includedMinimum" => [
                        "uid"      => false,
                        "language" => true,
                        "platform" => false
                    ]
                ]
            )
        );

        return $this->validate($validator);
    }
}
