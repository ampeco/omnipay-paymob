<?php

namespace Ampeco\OmnipayPayMob\Message;

use Ampeco\OmnipayPayMob\Gateway;

class PurchaseResponse extends Response
{
    public function isSuccessful()
    {
        if ($this->data['is_auth'] === 'true') {
            return $this->statusCode < 400;
        }

        return parent::isSuccessful() && $this->getCode() === Gateway::STATUS_SUCCESS;
    }
}
