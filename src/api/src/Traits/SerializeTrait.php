<?php

declare(strict_types=1);

namespace Api\Traits;

trait SerializeTrait
{
    protected function encode(string $text): string
    {
        return md5(strtolower(trim($text)));
    }
}
