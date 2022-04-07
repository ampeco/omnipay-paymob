<?php

namespace Ampeco\OmnipayPayMob\Message;

class VoidRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('transactionReference');

        return "{$this->getTransactionReference()}/cancel";
    }

    public function getData()
    {
        return [];
    }
}
