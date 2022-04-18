<?php

namespace Ampeco\OmnipayPayMob\Message;

class VoidRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        //https://accept.paymob.com/api/acceptance/void_refund/void?token=ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SndjbTltYVd4bFgzQnJJam94TmpZM056SXNJbkJvWVhOb0lqb2laV1k1TlRSbFptVTFNVEEwT1dReU5qZ3pZVFptTmpKaE4yUXhOVFF3WmpJek1EaGxOR0UxWkRaaFpqSXhNemhrWmpaaU9HWTJZVE16WlRCbFpqazBNQ0lzSW1Oc1lYTnpJam9pVFdWeVkyaGhiblFpTENKbGVIQWlPakUyTlRBeU9ERTJOamg5LjNsdzdpVXl3OXRtUVhzLWk2QWdranhJTHgxMXJWNmZIZ2tld0VKYjVBRHhrUWlLX0hTYVZXRkV3YW9wVnFydEtQQkV5TEoyQmF6RTVQVmFUZ2lOQUN3
        return "/acceptance/void_refund/void?token={$this->getAuthToken()}";
    }

    public function getData()
    {
        return [
            'transaction_id' => '',
        ];
    }
}
