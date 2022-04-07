<?php

namespace Ampeco\OmnipayPayMob\Message;

class CreateCardRequest extends AbstractRequest
{
    const ENDPOINT_TESTING = 'https://app.sandbox.PayMob.com/snap/v1';
    const ENDPOINT_PRODUCTION = 'https://app.PayMob.com/snap/v1';

    public function getEndpoint()
    {
        return 'transactions';
    }

    public function getHeaders(): array
    {
        return [
            'X-Override-Notification' => $this->getNotifyUrl(),
        ];
    }

    public function getData()
    {
        $this->validate('transactionId', 'userId', 'amount', 'returnUrl', 'notifyUrl');

        return [
            'transaction_details' => [
                'order_id' => $this->getTransactionId(),
                'gross_amount' => $this->getAmount(),
            ],
            'credit_card' => [
                'secure' => true,
                'save_card' => true,
            ],
            'enabled_payments' => ['credit_card'],
            'user_id' => $this->getUserId(),
            'callbacks' => [
                'finish' => $this->getReturnUrl(),
            ],
        ];
    }
}
