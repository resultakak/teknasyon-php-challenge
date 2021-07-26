<?php

declare(strict_types=1);

namespace Api\Providers;

use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

use function Api\Core\appPath;

class ConfigProvider implements ServiceProviderInterface
{
    public function register(DiInterface $container): void
    {
        $container->setShared('config', function () {
            $data = require appPath('config/config.php');

            return new Config($data);
        });
    }
}
