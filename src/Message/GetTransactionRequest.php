<?php

namespace Ampeco\OmnipayPayMob\Message;

class GetTransactionRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return "/acceptance/transactions/{$this->getTransactionId()}";
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function getData()
    {
        return [];
    }
}
