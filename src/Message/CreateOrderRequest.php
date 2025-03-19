<?php

namespace Ampeco\OmnipayPayMob\Message;

class CreateOrderRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return '/ecommerce/orders';
    }

    public function getData()
    {
        return [
            'amount_cents' => $this->getAmountInteger(),
            'currency' => $this->getCurrency(),
            'merchant_order_id' => $this->getTransactionId(),
        ];
    }

    public function getResponseClass()
    {
        return CreateOrderResponse::class;
    }
}
