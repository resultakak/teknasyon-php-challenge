<?php

declare(strict_types=1);

namespace Api\Component;

class PurchaseCard implements CardInterface
{

    /**
     * @var $receipt
     */
    public $receipt;

    /**
     * PurchaseCard constructor.
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $data = json_decode(json_encode($data), true);

        if (!isset($data) || empty($data) || !is_array($data)) {
            return;
        }

        if(array_key_exists('receipt', $data)) {
            $this->setReceipt($data['receipt']);
        }
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
     */
    public function setReceipt(string $receipt): void
    {
        $this->receipt = $receipt;
    }
}
