<?php

namespace Ampeco\OmnipayPayMob\Message;

use Ampeco\OmnipayPayMob\Gateway;

class SaleNotification extends BaseNotification
{
    // "transaction_time": "2022-03-11 21:57:09",
    // "transaction_status": "capture",
    // "transaction_id": "f858b827-52ab-4637-b875-9e8ef9623eb1",
    // "status_message": "PayMob payment notification",
    // "status_code": "200",
    // "signature_key": "0e678f13c9d1e04f085fb5afb1a2b30de139ea6f1397a3de08be8883bf2c8d835cf2a436532e90b201e4d64ad8987bab917e6fa4fa6ecbca88ea4e63f20ad550",
    // "saved_token_id_expired_at": "2025-01-31 07:00:00",
    // "saved_token_id": "481111zOsEMHJabjlisRWSsEgeHH1114",
    // "payment_type": "credit_card",
    // "order_id": "48f4a35aeb",
    // "merchant_id": "G337066901",
    // "masked_card": "481111-1114",
    // "gross_amount": "1.00",
    // "fraud_status": "accept",
    // "eci": "05",
    // "currency": "IDR",
    // "channel_response_message": "Approved",
    // "channel_response_code": "00",
    // "card_type": "credit",
    // "bank": "bni",
    // "approval_code": "1647010645548"

    public function isSuccessful(): bool
    {
        return parent::isSuccessful() && $this->getCode() === Gateway::STATUS_SUCCESS;
    }

    public function hasValidSignature(): bool
    {
//        $input = implode([
//            $this->data['order_id'],
//            $this->data['status_code'],
//            $this->data['gross_amount'],
//            $this->serverKey,
//        ]);
//
//        return openssl_digest($input, 'sha512') === $this->data['signature_key'];
    }

    public function getCode(): ?string
    {
        return $this->data['channel_response_code'];
    }

    public function isForTokenization(): bool
    {
        return $this->getToken() !== null;
    }

    public function getToken(): ?string
    {
        return @$this->data['obj']['token'];
    }

    public function getCardLastFour(): string
    {
        return substr($this->getCardNumber(), -4);
    }

    public function getCardFirstSix(): string
    {
        return substr($this->getCardNumber(), 0, 6);
    }

    public function getCardNumber(): string
    {
        return $this->data['masked_card'];
    }

    public function getExpirationMonth(): int
    {
        return intval(date('m', strtotime($this->getExpireDate())));
    }

    public function getExpirationYear(): int
    {
        return intval(date('Y', strtotime($this->getExpireDate())));
    }

    public function getExpireDate(): string
    {
//        return $this->data['saved_token_id_expired_at'];
    }
}
