<?php

declare(strict_types=1);

namespace Api\Traits;

use Phalcon\Crypt;
use function getenv;

trait CryptoTrait
{

    private function getKey() {
        return base64_decode(getenv('APP_KEY'));
    }

    protected function encrypt(string $text)
    {
        /** @var Crypt $crypt */
        $crypt     = new Crypt();
        $key = $this->getKey();

        return $crypt->encrypt($text, $key);
    }


    protected function decrypt(string $encrypted)
    {
        /** @var Crypt $crypt */
        $crypt     = new Crypt();
        $key = $this->getKey();

        return $crypt->decrypt($encrypted, $key);
    }
}
