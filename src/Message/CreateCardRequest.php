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
        // $this->validate('transactionId', 'userId', 'amount', 'returnUrl', 'notifyUrl');

        //TODO Use $data directly below and dont access information from this?!
        return [];
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

        return $this->createResponse(
            json_encode([
                'redirect_url' => $this->getRedirectUrl($paymentToken),
                'order_id' => $orderId,
            ]),
            Response::HTTP_OK,
        );
    }

    private function getRedirectUrl($paymentToken)
    {
        return self::IFRAME_BASE_URL . $this->getCardIframeId() . '?payment_token=' . $paymentToken;
    }
}
