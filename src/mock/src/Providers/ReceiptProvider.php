<?php

declare(strict_types=1);

namespace App\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use App\Receipt\Receipt;

class ReceiptProvider implements ServiceProviderInterface
{

    public function register(DiInterface $container): void
    {
        $container->set(
            'receipt',
            function () {
                $receipt = new Receipt();

                return $receipt;
            }
        );
    }
}
