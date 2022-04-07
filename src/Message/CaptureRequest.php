<?php

namespace Ampeco\OmnipayPayMob\Message;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'capture';
    }

    public function getData()
    {
        $this->validate('amount', 'transactionReference');

        return [
            'transaction_id' => $this->getTransactionReference(),
            'gross_amount' => $this->getAmount(),
        ];
    }
}
