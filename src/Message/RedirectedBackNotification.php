<?php

namespace Ampeco\OmnipayPayMob\Message;

class RedirectedBackNotification extends BaseNotification
{
    public function getTransactionReference()
    {
        return @$this->data['id'];
    }
}
