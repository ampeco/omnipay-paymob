<?php

namespace Ampeco\OmnipayPayMob;

trait CommonParameters
{
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getPaymentIntegrationId()
    {
        return $this->getParameter('paymentIntegrationId');
    }

    public function setPaymentIntegrationId($value)
    {
        return $this->setParameter('paymentIntegrationId', $value);
    }

    public function getAuthIntegrationId()
    {
        return $this->getParameter('authIntegrationId');
    }

    public function setAuthIntegrationId($value)
    {
        return $this->setParameter('authIntegrationId', $value);
    }

    public function getCardIframeId()
    {
        return $this->getParameter('cardIframeId');
    }

    public function setCardIframeId($value)
    {
        return $this->setParameter('cardIframeId', $value);
    }
}
