<?php

namespace Ampeco\OmnipayPayMob\Message;

use Omnipay\Common\Message\NotificationInterface;

class BaseNotification implements NotificationInterface
{
    const STATUS_SUCCESS = 200;

    protected $data;
    protected $serverKey;

    public function __construct($data, $serverKey)
    {
        $this->data = $data;
        $this->serverKey = $serverKey;
    }

    public function getTransactionStatus(): int
    {
        return @$this->data['status_code'];
    }

    public function getMessage()
    {
        return $this->getTransactionStatus();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTransactionReference()
    {
        return @$this->data['transaction_id'];
    }

    public function isSuccessful(): bool
    {
        return $this->getTransactionStatus() === self::STATUS_SUCCESS;
    }
}
