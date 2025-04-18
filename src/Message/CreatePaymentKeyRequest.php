<?php

namespace Ampeco\OmnipayPayMob\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class CreatePaymentKeyRequest extends AbstractRequest
{
    public function getIntegrationId()
    {
        return $this->getParameter('integrationId');
    }

    public function setIntegrationId($value)
    {
        return $this->setParameter('integrationId', $value);
    }

    public function getEndpoint()
    {
        return '/acceptance/payment_keys';
    }

    public function getData()
    {
        $this->validate('amount', 'orderId', 'email', 'firstName', 'lastName', 'phone', 'currency');

        $integrationId = $this->getIntegrationId();

        if (!$integrationId) {
            throw new InvalidRequestException('The integrationId parameter is required');
        }

        return [
            'amount_cents' => $this->getAmountInteger(),
            'order_id' => $this->getOrderId(),
            'billing_data' => [
                'apartment' => 'NA',
                'email' => $this->getEmail(),
                'floor' => 'NA',
                'first_name' => $this->getFirstName(),
                'street' => 'NA',
                'building' => 'NA',
                'phone_number' => $this->getPhone(),
                'shipping_method' => 'NA',
                'postal_code' => 'NA',
                'city' => 'NA',
                'country' => 'NA',
                'last_name' => $this->getLastName(),
                'state' => 'NA',
            ],
            'currency' => $this->getCurrency(),
            'integration_id' => $integrationId,
        ];
    }

    public function getResponseClass()
    {
        return CreatePaymentKeyResponse::class;
    }
}
