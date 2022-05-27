<?php

namespace Ampeco\OmnipayPayMob\Message;

class CreatePaymentKeyResponse extends Response
{
    const IFRAME_BASE_URL = 'https://accept.paymob.com/api/acceptance/iframes/';

    public function isSuccessful()
    {
        return $this->statusCode < 400 && @$this->data['token'];
    }

    public function getPaymentToken()
    {
        return @$this->data['token'];
    }

    public function getRedirectUrl()
    {
        return self::IFRAME_BASE_URL . $this->request->getParameters()['cardIframeId'] . '?payment_token=' . $this->getPaymentToken();
    }
}
