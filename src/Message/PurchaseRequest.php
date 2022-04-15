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
        $headers = array_merge($this->getHeaders(), [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

        $authToken = $this->getAuthToken();

        $orderData = [
            'auth_token' => $authToken,
            'amount_cents' => $this->getAmount() * 100,
            'currency' => $this->getCurrency(),
            'merchant_order_id' => $this->getTransactionId(),
        ];

        //create order
        $orderResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . '/ecommerce/orders',
            $headers,
            json_encode($orderData),
        );

        $orderDecodedResponse = json_decode($orderResponse->getBody()->getContents(), true);

        if ($orderResponse->getStatusCode() >= 400) {
            throw new \Exception($orderDecodedResponse['detail']);
        }

        $orderId = $orderDecodedResponse['id'];
        info('ORDER ID:' . $orderId);

        $paymentKeyData = [
            'auth_token' => $authToken,
            //            'expiration' => 3600 //The expiration time of this payment token in seconds.
            'amount_cents' => $this->getAmount() * 100,
            'order_id' => $orderId,
            'billing_data' => [
                'apartment'=> 'NA',
                'email'=> $this->getEmail(),
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
            'currency' => $this->getCurrency(),
            'integration_id' => $this->getPaymentIntegrationId(),
        ];

        //get payment token for iframe
        $paymentKeyResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . '/acceptance/payment_keys',
            $headers,
            json_encode($paymentKeyData),
        );

        $paymentKeyDecodedResponse = json_decode($paymentKeyResponse->getBody()->getContents(), true);

        if ($paymentKeyResponse->getStatusCode() >= 400) {
            throw new \Exception($paymentKeyDecodedResponse['detail']);
        }

        $paymentToken = $paymentKeyDecodedResponse['token'];

        info('PAYMENT TOKEN:' . $paymentToken);

        $paymentData = [
            'source' => [
                'identifier' => $this->getToken(),
                'subtype' => 'TOKEN',
            ],
            'payment_token' => $paymentToken,
        ];

        $paymentResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . '/acceptance/payments/pay',
            $headers,
            json_encode($paymentData),
        );

        return $this->createResponse($paymentResponse->getBody()->getContents(), Response::HTTP_OK);
    }

    protected function getResponseClass()
    {
        return PurchaseResponse::class;
    }
}
