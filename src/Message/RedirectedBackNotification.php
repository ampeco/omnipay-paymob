<?php

namespace Ampeco\OmnipayPayMob\Message;

class RedirectedBackNotification extends BaseNotification
{
    public function getTransactionReference()
    {
        return @$this->data['id'];
    }

    public function getMessage()
    {
        return @$this->data['data_message'];
    }
}
