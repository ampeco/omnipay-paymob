<?php

namespace Ampeco\OmnipayPayMob\Message;

use Ampeco\OmnipayPayMob\CommonParameters;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    use CommonParameters;

    const ENDPOINT_PRODUCTION = 'https://accept.paymob.com/api';

    abstract public function getEndpoint();

    public function getBaseUrl()
    {
        return static::ENDPOINT_PRODUCTION;
    }

    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @inheritdoc
     */
    public function sendData($data)
    {
        $headers = $this->getHeaders();

        $data['auth_token'] = $this->getAuthToken();

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            rtrim($this->getBaseUrl(), '/') . '/' . ltrim($this->getEndpoint(), '/'),
            $headers,
            json_encode($data),
        );

        return $this->createResponse(
            $httpResponse->getBody()->getContents(),
            $httpResponse->getStatusCode(),
        );
    }

    protected function createResponse($data, $statusCode)
    {
        $responseClass = $this->getResponseClass();

        return $this->response = new $responseClass($this, $data, $statusCode);
    }

    protected function getResponseClass()
    {
        return Response::class;
    }

    public function getAuthToken()
    {
        $response = $this->httpClient->request('POST',
            $this->getBaseUrl() . '/auth/tokens',
            ['Content-Type' => 'application/json'],
            json_encode([
                'api_key' => $this->getApiKey(),
            ])
        );

        $decodedResponse = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() >= 400) {
            throw new \Exception($decodedResponse['detail']);
        }

        return $decodedResponse['token'];
    }

    public function createOrder($authToken)
    {
        $orderData = [
            'auth_token' => $authToken,
            'amount_cents' => $this->getAmount() * 100,
            'currency' => $this->getCurrency(),
            'merchant_order_id' => $this->getTransactionId(),
        ];

        // 1. Create order
        $orderResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . '/ecommerce/orders',
            $this->getHeaders(),
            json_encode($orderData),
        );

        $orderDecodedResponse = json_decode($orderResponse->getBody()->getContents(), true);

        if ($orderResponse->getStatusCode() >= 400) {
            throw new \Exception($orderDecodedResponse['detail']);
        }

        return $orderDecodedResponse;
    }

    public function createPaymentKey($authToken, $data)
    {
        $paymentKeyData = [
            'auth_token' => $authToken,
            'amount_cents' => (float) $data['amount'] * 100,
            'order_id' => $data['orderId'],
            'billing_data' => [
                'apartment'=> 'NA',
                'email'=> $data['email'],
                'floor'=> 'NA',
                'first_name'=> 'Clifford',
                'street'=> 'NA',
                'building'=> 'NA',
                'phone_number'=> '+86(8)9135210487',
                'shipping_method'=> 'PKG',
                'postal_code'=> 'NA',
                'city'=> 'NA',
                'country'=> 'NA',
                'last_name'=> 'Nicolas',
                'state'=> 'NA',
            ],
            'currency' => $data['currency'],
            'integration_id' => $this->getPaymentIntegrationId(),
        ];

        $paymentKeyResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . '/acceptance/payment_keys',
            $this->getHeaders(),
            json_encode($paymentKeyData),
        );

        $paymentKeyDecodedResponse = json_decode($paymentKeyResponse->getBody()->getContents(), true);

        if ($paymentKeyResponse->getStatusCode() >= 400) {
            throw new \Exception($paymentKeyDecodedResponse['detail']);
        }

        return $paymentKeyDecodedResponse;
    }
}
