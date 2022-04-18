<?php

namespace Ampeco\OmnipayPayMob\Message;

use Symfony\Component\HttpFoundation\Response;

class VoidRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return null;
    }

    public function sendData($data)
    {
        $authToken = $this->getAuthToken();

        $orderData = [
            'auth_token' => $authToken,
            'order_id' => $this->getTransactionReference(),
            'merchant_order_id' => $this->getTransactionId(),
        ];

        $transactionResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . '/ecommerce/orders/transaction_inquiry',
            $this->getHeaders(),
            json_encode($orderData),
        );

        $transaction = json_decode($transactionResponse->getBody()->getContents(), true);

        $voidData = [
            'transaction_id' => $transaction['id'],
        ];

        $voidResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . "/acceptance/void_refund/void?token=$authToken",
            $this->getHeaders(),
            json_encode($voidData),
        );

        return $this->createResponse($voidResponse->getBody()->getContents(), Response::HTTP_OK);
    }

    public function getData()
    {
        return [];
    }
}
