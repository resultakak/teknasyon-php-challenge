<?php

declare(strict_types=1);

namespace Api\Traits;

use Phalcon\Crypt;

use function base64_encode;
use function getenv;

trait CryptoTrait
{
    /**
     * @param string $text
     * @return string
     */
    protected function encrypt(string $text): string
    {
        /** @var Crypt $crypt */
        $crypt = new Crypt();
        $key = $this->getKey();

        return base64_encode($crypt->encrypt($text, $key));
    }

    /**
     * @return false|string
     */
    private function getKey()
    {
        return base64_decode(getenv('APP_KEY'));
    }

    /**
     * @param string $encrypted
     * @return mixed
     */
    protected function decrypt(string $encrypted)
    {
        /** @var Crypt $crypt */
        $crypt = new Crypt();
        $key = $this->getKey();

        return $crypt->decrypt(base64_decode($encrypted), $key);
    }
}
