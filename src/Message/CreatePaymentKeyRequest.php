<?php

namespace Ampeco\OmnipayPayMob\Message;

class CreatePaymentKeyRequest extends AbstractRequest
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
        return '/acceptance/payment_keys';
    }

    public function getData()
    {
        $this->validate('amount', 'orderId', 'email', 'firstName', 'lastName', 'phone', 'currency', 'hold');

        return [
            'amount_cents' => $this->getAmount() * 100,
            'order_id' => $this->getOrderId(),
            'billing_data' => [
                'apartment'=> 'NA',
                'email'=> $this->getEmail(),
                'floor'=> 'NA',
                'first_name'=> $this->getFirstName(),
                'street'=> 'NA',
                'building'=> 'NA',
                'phone_number'=> $this->getPhone(),
                'shipping_method'=> 'NA',
                'postal_code'=> 'NA',
                'city'=> 'NA',
                'country'=> 'NA',
                'last_name'=> $this->getLastName(),
                'state'=> 'NA',
            ],
            'currency' => $this->getCurrency(),
            'integration_id' => $this->getHold() ? $this->getAuthIntegrationId() : $this->getMotoIntegrationId(),
        ];
    }

    public function getResponseClass()
    {
        return CreatePaymentKeyResponse::class;
    }
}
