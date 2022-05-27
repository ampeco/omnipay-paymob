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

        $authToken = $this->getAuthToken();

        $requestUrl = rtrim($this->getBaseUrl(), '/') . '/' . ltrim($this->getEndpoint(), '/');

        if ($this->shouldAttachAuthTokenAsQueryParam()) {
            $requestUrl .= '?token=' . $authToken;
        } else {
            $data['auth_token'] = $authToken;
        }

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $requestUrl,
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

    public function shouldAttachAuthTokenAsQueryParam()
    {
        return false;
    }
}
