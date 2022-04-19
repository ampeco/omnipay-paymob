<?php

namespace Ampeco\OmnipayPayMob\Message;

use Symfony\Component\HttpFoundation\Response;

class CreateCardRequest extends AbstractRequest
{
    const IFRAME_BASE_URL = 'https://accept.paymob.com/api/acceptance/iframes/';

    public function getEndpoint()
    {
        // TODO: Implement getEndpoint() method.
    }

    public function getData()
    {
        $this->validate('orderId', 'email', 'currency', 'amount');

        return [
            'orderId' => $this->getOrderId(),
            'email' => $this->getEmail(),
            'currency' => $this->getCurrency(),
            'amount' => $this->getAmount(),
        ];
    }

    public function sendData($data)
    {
        $authToken = $this->getAuthToken();
        $paymentKey = $this->createPaymentKey($authToken, $data);

        return $this->createResponse(
            json_encode([
                'redirect_url' => $this->getRedirectUrl($paymentKey['token']),
                'order_id' => $data['orderId'],
                'success' => true,
            ]),
            Response::HTTP_OK,
        );
    }

    private function getRedirectUrl($paymentToken)
    {
        return self::IFRAME_BASE_URL . $this->getCardIframeId() . '?payment_token=' . $paymentToken;
    }
}
