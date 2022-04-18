<?php

namespace Ampeco\OmnipayPayMob\Message;

use Symfony\Component\HttpFoundation\Response;

class PurchaseRequest extends AbstractRequest
{
    public function setHold($value)
    {
        $this->setParameter('hold', (bool) $value);
    }

    public function getHold()
    {
        return $this->getParameter('hold');
    }

    public function getEndpoint()
    {
        // TODO: Implement getEndpoint() method.
    }

    public function getData()
    {
        // TODO: Implement getData() method.
    }

    public function sendData($data)
    {
        $authToken = $this->getAuthToken();
        $order = $this->createOrder($authToken);
        info('ORDER ID:' . $order['id']);

        $paymentToken = $this->createPaymentKey($authToken, $order);
        info('PAYMENT TOKEN:' . $paymentToken['token']);

        $paymentData = [
            'source' => [
                'identifier' => $this->getToken(),
                'subtype' => 'TOKEN',
            ],
            'payment_token' => $paymentToken['token'],
        ];

        $paymentResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . '/acceptance/payments/pay',
            $this->getHeaders(),
            json_encode($paymentData),
        );

        return $this->createResponse($paymentResponse->getBody()->getContents(), Response::HTTP_OK);
    }

    protected function getResponseClass()
    {
        return PurchaseResponse::class;
    }
}
