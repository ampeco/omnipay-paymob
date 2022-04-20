<?php

namespace Ampeco\OmnipayPayMob\Message;

class CreatePaymentKeyResponse extends Response
{
    public function isSuccessful()
    {
        return $this->statusCode < 400 && $this->data['token'];
    }
}
