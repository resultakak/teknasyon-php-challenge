<?php

declare(strict_types=1);

namespace Api\Providers;

use Monolog\Logger;
use Api\ErrorHandler;
use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use function register_shutdown_function;
use function set_error_handler;

class ErrorHandlerProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     *
     * @param DiInterface $container
     */
    public function register(DiInterface $container): void
    {
        /** @var Logger $logger */
        $logger  = $container->getShared('logger');
        /** @var Config $registry */
        $config  = $container->getShared('config');

        date_default_timezone_set($config->path('app.timezone'));
        ini_set('display_errors', 'Off');
        error_reporting(E_ALL);

        $handler = new ErrorHandler($logger, $config);
        set_error_handler([$handler, 'handle']);
        register_shutdown_function([$handler, 'shutdown']);
    }
}
