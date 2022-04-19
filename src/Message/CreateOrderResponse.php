<?php

namespace Ampeco\OmnipayPayMob\Message;

class CreateOrderResponse extends Response
{
    public function isSuccessful()
    {
        return $this->statusCode < 400;
    }
}
