<?php

namespace Ampeco\OmnipayPayMob\Message;

class CreateTransactionInquiryResponse extends Response
{
    public function isSuccessful()
    {
        return $this->statusCode < 400;
    }
}
