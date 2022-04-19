<?php

namespace Ampeco\OmnipayPayMob\Message;

class VoidRequest extends AbstractRequest
{
    public function shouldAttachAuthTokenAsQueryParam()
    {
        return true;
    }

    public function getEndpoint()
    {
        return '/acceptance/void_refund/void';
    }

    public function getData()
    {
        return [
            'transaction_id' => $this->getTransactionReference(),
        ];
    }
}
