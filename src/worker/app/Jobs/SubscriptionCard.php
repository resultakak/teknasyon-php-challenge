<?php

namespace App\Jobs;

class SubscriptionCard
{
    /**
     * @var int $sid
     */
    public $sid;

    /**
     * @var int $daid
     */
    public $daid;

    /**
     * @var string $receipt
     */
    public $receipt;

    /**
     * @var string $expire_date
     */
    public $expire_date;

    /**
     * @var string $event
     */
    public $event;

    /**
     * @var string $username
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @return int
     */
    public function getSid(): int
    {
        return $this->sid;
    }

    /**
     * @param int $sid
     * @return $this
     */
    public function setSid(int $sid): self
    {
        $this->sid = $sid;

        return $this;
    }

    /**
     * @return int
     */
    public function getDaid(): int
    {
        return $this->daid;
    }

    /**
     * @param int $daid
     * @return $this
     */
    public function setDaid(int $daid): self
    {
        $this->daid = $daid;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceipt(): string
    {
        return $this->receipt;
    }

    /**
     * @param string $receipt
     * @return $this
     */
    public function setReceipt(string $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpireDate(): string
    {
        return $this->expire_date;
    }

    /**
     * @param string $expire_date
     * @return $this
     */
    public function setExpireDate(string $expire_date): self
    {
        $this->expire_date = $expire_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $event
     * @return $this
     */
    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
