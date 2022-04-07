<?php

namespace Ampeco\OmnipayPayMob\Message;

use Ampeco\OmnipayPayMob\Gateway;

class PurchaseResponse extends Response
{
    public function isSuccessful()
    {
        return parent::isSuccessful() && $this->getCode() === Gateway::STATUS_SUCCESS;
    }
}
