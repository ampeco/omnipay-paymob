<?php

namespace Ampeco\OmnipayPayMob\Message;

use Ampeco\OmnipayPayMob\Gateway;

class SaleNotification extends BaseNotification
{
    public function isSuccessful(): bool
    {
        return parent::isSuccessful() && $this->getCode() === Gateway::STATUS_SUCCESS;
    }

    public function getCode(): ?string
    {
        return null; //Should be user in other notification
        //return $this->data['channel_response_code'];
    }

    public function isForTokenization(): bool
    {
        return $this->data['type'] === 'TOKEN' && $this->getToken();
    }

    public function getToken(): ?string
    {
        return @$this->data['obj']['token'];
    }

    public function getCardLastFour(): string
    {
        return substr($this->getCardNumber(), -4);
    }

    public function getCardBrand(): string
    {
        return $this->data['obj']['card_subtype'];
    }

    public function getCardNumber(): string
    {
        return $this->data['obj']['masked_pan'];
    }

    public function getCustomerEmail(): string
    {
        return $this->data['obj']['email'];
    }
}
