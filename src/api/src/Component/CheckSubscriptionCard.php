<?php

declare(strict_types=1);

namespace Api\Component;

use JsonSerializable;

class CheckSubscriptionCard implements CardInterface, JsonSerializable
{
    /**
     * @var $status
     */
    private $status;

    /**
     * @var $expire_date
     */
    private $expire_date;

    /**
     * MockResultCard constructor.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $data = json_decode(json_encode($data), true);

        if (! isset($data) || empty($data) || ! is_array($data)) {
            return;
        }

        if (array_key_exists('status', $data)) {
            $this->setStatus((bool) $data['status']);
        }

        if (array_key_exists('expire_date', $data)) {
            $this->setExpireDate($data['expire_date']);
        }
    }

    /**
     * @return bool
     */
    public function hasStatus(): bool
    {
        return $this->status ?? false;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * @param $expire_date
     * @return $this
     */
    public function setExpireDate($expire_date): self
    {
        $this->expire_date = isset($expire_date) ? date('Y-m-d H:i:s', strtotime($expire_date)) : null;

        return $this;
    }

    public function jsonSerialize()
    {
        $data = [
            'status' => $this->hasStatus(),
        ];

        if (true === $this->hasStatus()) {
            $data['expire_date'] = $this->getExpireDate();
        }

        return $data;
    }
}
