<?php

declare(strict_types=1);

namespace Api\Component;

use JsonSerializable;

class CheckSubscriptionCard implements JsonSerializable, CardInterface
{

    /**
     * @var $token
     */
    private $token;

    public function __construct(array $data = null)
    {
        $data = json_decode(json_encode($data), true);

        if (!isset($data) || empty($data) || !is_array($data)) {
            return;
        }

        if(array_key_exists('token', $data)) {
            $this->setToken($data['token']);
        }
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [""];
    }
}
