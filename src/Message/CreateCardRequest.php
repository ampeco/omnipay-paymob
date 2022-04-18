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
        // $this->validate('transactionId', 'userId', 'amount');

        //TODO Use $data directly below and dont access information from this?!
        return [];
    }

    public function sendData($data)
    {
        $authToken = $this->getAuthToken();
        $order = $this->createOrder($authToken);
        info('ORDER ID:' . $order['id']);

        $paymentKey = $this->createPaymentKey($authToken, $order);
        info('PAYMENT TOKEN:' . $paymentKey['token']);

        return $this->createResponse(
            json_encode([
                'redirect_url' => $this->getRedirectUrl($paymentKey['token']),
                'order_id' => $order['id'],
            ]),
            Response::HTTP_OK,
        );
    }

    private function getRedirectUrl($paymentToken)
    {
        return self::IFRAME_BASE_URL . $this->getCardIframeId() . '?payment_token=' . $paymentToken;
    }
}
