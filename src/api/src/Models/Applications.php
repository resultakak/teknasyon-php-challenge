<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength;

/**
 * Class Applications
 *
 * @method setSource(string)
 */
class Applications extends Model
{
    /**
     * @var integer $aid
     */
    public $aid;

    /**
     * @var string $app_id
     */
    public $app_id;

    /**
     * @var string $created
     */
    public $created;

    /**
     * @return void
     */
    public function initialize(): void
    {
        $this->setSource('apps');

        $this->hasMany(
            'aid',
            AppCredentials::class,
            'aid',
            [
                'reusable' => true,
                'alias'    => 'credential'
            ]
        );
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            [
                "app_id"
            ],
            new StringLength(
                [
                    "max" => [
                        "app_id" => 70,
                    ],
                    "min" => [
                        "app_id" => 30
                    ],
                    "messageMaximum" => [
                        "app_id" => "Internal Server Error",
                    ],
                    "messageMinimum" => [
                        "app_id" => "Internal Server Error",
                    ],
                    "includedMaximum" => [
                        "app_id" => true
                    ],
                    "includedMinimum" => [
                        "app_id" => true
                    ]
                ]
            )
        );

        return $this->validate($validator);
    }
}
