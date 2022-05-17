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

    public function getOnlineIntegrationId()
    {
        return $this->getParameter('onlineIntegrationId');
    }

    public function setOnlineIntegrationId($value)
    {
        return $this->setParameter('onlineIntegrationId', $value);
    }

    public function getMotoIntegrationId()
    {
        return $this->getParameter('motoIntegrationId');
    }

    public function setMotoIntegrationId($value)
    {
        return $this->setParameter('motoIntegrationId', $value);
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

    public function setOrderId($value)
    {
        $this->setParameter('orderId', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setMerchantOrderId($value)
    {
        $this->setParameter('merchantOrderId', $value);
    }

    public function getMerchantOrderId()
    {
        return $this->getParameter('merchantOrderId');
    }

    public function setPhone($value)
    {
        $this->setParameter('phone', $value);
    }

    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    public function setFirstName($value)
    {
        $this->setParameter('firstName', $value);
    }

    public function getFirstName()
    {
        return $this->getParameter('firstName');
    }

    public function setLastName($value)
    {
        $this->setParameter('lastName', $value);
    }

    public function getLastName()
    {
        return $this->getParameter('lastName');
    }
}
