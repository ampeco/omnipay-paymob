<?php

namespace Ampeco\OmnipayPayMob\Message;

use Omnipay\Common\Message\NotificationInterface;

class BaseNotification implements NotificationInterface
{
    const STATUS_SUCCESS = 'APPROVED';

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getTransactionStatus()
    {
        return @$this->data['txn_response_code'];
    }

    public function getMessage()
    {
        return @$this->data['obj']['data']['message'];
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTransactionReference()
    {
        return @$this->data['obj']['order_id'];
    }

    public function isSuccessful(): bool
    {
        return $this->getTransactionStatus() === self::STATUS_SUCCESS;
    }
}
