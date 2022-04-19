<?php

namespace Ampeco\OmnipayPayMob\Message;

class CreateTransactionInquiryRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'ecommerce/orders/transaction_inquiry';
    }

    public function getData()
    {
        return [
            'merchant_order_id' => $this->getMerchantOrderId(),
            'order_id' => $this->getOrderId(),
        ];
    }

    public function getResponse()
    {
        return CreateTransactionInquiryResponse::class;
    }
}
