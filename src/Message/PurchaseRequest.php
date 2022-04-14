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

    public function getEndpoint()
    {
        return 'charge';
    }

    public function getData()
    {
//        $this->validate('token', 'transactionId', 'amount');

        $params = [
            'source' => [
                'identifier' => $this->getToken(),
                'subtype' => 'TOKEN',
            ],
//            'payment_token' =>
        ];

        if ($this->getHold()) {
            $params['integration_id'] = $this->getAuthIntegrationId();
        }

        return $params;
    }

    protected function getResponseClass()
    {
        return PurchaseResponse::class;
    }
}
