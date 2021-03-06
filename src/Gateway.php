<?php

namespace Ampeco\OmnipayPayMob;

use Ampeco\OmnipayPayMob\Message\AbstractRequest;
use Ampeco\OmnipayPayMob\Message\CaptureRequest;
use Ampeco\OmnipayPayMob\Message\CreateCardRequest;
use Ampeco\OmnipayPayMob\Message\CreateOrderRequest;
use Ampeco\OmnipayPayMob\Message\CreatePaymentKeyRequest;
use Ampeco\OmnipayPayMob\Message\GetTransactionRequest;
use Ampeco\OmnipayPayMob\Message\PurchaseRequest;
use Ampeco\OmnipayPayMob\Message\RedirectedBackNotification;
use Ampeco\OmnipayPayMob\Message\TransactionInquiryRequest;
use Ampeco\OmnipayPayMob\Message\TransactionNotification;
use Ampeco\OmnipayPayMob\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;

/**
 * @method \Omnipay\Common\Message\AbstractRequest completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest completePurchase(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest refund(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest fetchTransaction(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest updateCard(array $options = [])
 */
class Gateway extends AbstractGateway
{
    use CommonParameters;

    const STATUS_SUCCESS = 'APPROVED';

    public function getName()
    {
        return 'PayMob';
    }

    public function getCreateCardAmount()
    {
        return 1;
    }

    public function getCreateCardCurrency()
    {
        return 'EGP';
    }

    public function createOrder(array $options = []): AbstractRequest
    {
        return $this->createRequest(CreateOrderRequest::class, $options);
    }

    public function createCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(CreatePaymentKeyRequest::class, array_merge($options, [
            'integrationId' => $this->getOnlineIntegrationId(),
        ]));
    }

    public function authorize(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function capture(array $options = []): AbstractRequest
    {
        return $this->createRequest(CaptureRequest::class, $options);
    }

    public function void(array $options = []): AbstractRequest
    {
        return $this->createRequest(VoidRequest::class, $options);
    }

    public function purchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function transactionInquiry(array $options = []): AbstractRequest
    {
        return $this->createRequest(TransactionInquiryRequest::class, $options);
    }

    public function getTransaction(array $options = []): AbstractRequest
    {
        return $this->createRequest(GetTransactionRequest::class, $options);
    }

    public function createPaymentKeyForNextPayments(array $options = []): AbstractRequest
    {
        return $this->createRequest(CreatePaymentKeyRequest::class, array_merge($options, [
            'integrationId' => $this->getMotoIntegrationId(),
        ]));
    }

    public function createPaymentKeyForPreAuthorization(array $options = []): AbstractRequest
    {
        return $this->createRequest(CreatePaymentKeyRequest::class, array_merge($options, [
            'integrationId' => $this->getAuthIntegrationId(),
        ]));
    }

    public function deleteCard(array $options = []): AbstractRequest
    {
        throw new \Exception('Delete card is not supported by the payment provider');
    }

    public function acceptNotification(array $options = []): TransactionNotification
    {
        return new TransactionNotification($options);
    }

    public function acceptRedirectedBack(array $options = []): RedirectedBackNotification
    {
        return new RedirectedBackNotification($options);
    }
}
