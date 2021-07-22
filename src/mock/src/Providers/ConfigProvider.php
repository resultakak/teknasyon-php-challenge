<?php

declare(strict_types=1);

namespace App\Providers;

use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use function App\Core\appPath;

class ConfigProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $container
     */
    public function register(DiInterface $container): void
    {
        $container->setShared(
            'config',
            function () {
                $data = require appPath('api/config/config.php');

                return new Config($data);
            }
        );
    }
}
