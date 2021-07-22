<?php

declare(strict_types=1);

namespace App\Providers;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use function App\Core\appPath;
use function App\Core\envValue;

class LoggerProvider implements ServiceProviderInterface
{
    /**
     * Registers the logger component
     *
     * @param DiInterface $container
     */
    public function register(DiInterface $container): void
    {
        $container->setShared(
            'logger',
            function () {
                /** @var string $logName */
                $logName   = envValue('LOGGER_DEFAULT_FILENAME', 'api.log');
                /** @var string $logPath */
                $logPath   = envValue('LOGGER_DEFAULT_PATH', 'storage/logs');
                $logFile   = appPath($logPath) . '/' . $logName . '.log';
                $formatter = new LineFormatter("[%datetime%][%level_name%] %message%\n");
                $logger    = new Logger('api-logger');
                $handler   = new StreamHandler($logFile, Logger::DEBUG);
                $handler->setFormatter($formatter);
                $logger->pushHandler($handler);

                return $logger;
            }
        );
    }
}
