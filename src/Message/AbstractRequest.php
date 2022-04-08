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
        return [];
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
        $headers = array_merge($this->getHeaders(), [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

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

        info('TOKEN:'. $decodedResponse['token']);
        return $decodedResponse['token'];
    }
}
