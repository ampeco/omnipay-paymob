<?php

namespace Ampeco\OmnipayPayMob\Tests\Unit;

use Ampeco\OmnipayPayMob\Gateway;
use Omnipay\Omnipay;
use PHPUnit\Framework\TestCase;

class CreateOrderRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_uses_pre_authorize_mode_when_session_authorization()
    {
        $gateway = Omnipay::create('\\' . Gateway::class);

        $request = $gateway->createOrder([
            'amount' => 0.07,
            'currency' => 'EGP',
            'transactionId' => 'test123',
            'email' => 'test@test.com',
        ]);

        $this->assertEquals(7, $request->getData()['amount_cents']);

        $request = $gateway->createOrder([
            'amount' => 7,
            'currency' => 'EGP',
            'transactionId' => 'test123',
            'email' => 'test@test.com',
        ]);

        $this->assertEquals(700, $request->getData()['amount_cents']);
    }
}
