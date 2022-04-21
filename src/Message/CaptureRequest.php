<?php

namespace Ampeco\OmnipayPayMob\Message;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return '/acceptance/capture';
    }

    public function getData()
    {
        $this->validate('amount', 'transactionReference');

        return [
            'transaction_id' => $this->getTransactionReference(),
            'amount_cents' => $this->getAmount() * 100,
        ];
    }
}
