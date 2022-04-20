<?php

namespace Ampeco\OmnipayPayMob\Message;

class PurchaseRequest extends AbstractRequest
{
    public function setHold($value)
    {
        $this->setParameter('hold', (bool) $value);
    }

    public function getHold()
    {
        return $this->getParameter('hold');
    }

    public function setIdentifier($value)
    {
        $this->setParameter('identifier', $value);
    }

    public function getIdentifier()
    {
        return $this->getParameter('identifier');
    }

    public function setPaymentToken($value)
    {
        $this->setParameter('paymentToken', $value);
    }

    public function getPaymentToken()
    {
        return $this->getParameter('paymentToken');
    }

    public function getEndpoint()
    {
        return '/acceptance/payments/pay';
    }

    public function getData()
    {
        $this->validate('identifier', 'paymentToken');

        return [
            'source' => [
                'identifier' => $this->getIdentifier(),
                'subtype' => 'TOKEN',
            ],
            'payment_token' => $this->getPaymentToken(),
        ];
    }

    protected function getResponseClass()
    {
        return PurchaseResponse::class;
    }
}
