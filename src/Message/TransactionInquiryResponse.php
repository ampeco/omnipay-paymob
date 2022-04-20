<?php

namespace Ampeco\OmnipayPayMob\Message;

class TransactionInquiryResponse extends Response
{
    public function isSuccessful()
    {
        return $this->statusCode < 400;
    }
}
