<?php

namespace Ampeco\OmnipayPayMob\Message;

class PurchaseResponse extends Response
{
    public function isPending()
    {
        return $this->data['pending'] === 'true';
    }
}
