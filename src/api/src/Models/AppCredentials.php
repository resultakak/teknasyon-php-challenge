<?php

declare(strict_types=1);

namespace Api\Models;

use Phalcon\Mvc\Model;

/**
 * Class Applications
 *
 * @method setSource(string)
 */
class AppCredentials extends Model
{
    /**
     * @var integer $acid
     */
    public $acid;

    /**
     * @var integer $aid
     */
    public $aid;

    /**
     * @var string $username
     */
    public $username;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var string $platform
     */
    public $platform;

    /**
     * @var string $created
     */
    public $created;

    /**
     * @return void
     */
    public function initialize(): void
    {
        $this->setSource('app_credentials');

        $this->belongsTo(
            'aid',
            Applications::class,
            'aid',
            [
                'reusable' => true,
                'alias'    => 'app'
            ]
        );
    }
}
