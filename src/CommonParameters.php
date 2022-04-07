<?php

namespace Ampeco\OmnipayPayMob;

trait CommonParameters
{
    public function getServerKey()
    {
        return $this->getParameter('serverKey');
    }

    public function setServerKey($value)
    {
        return $this->setParameter('serverKey', $value);
    }

    public function getUserId()
    {
        return $this->getParameter('userId');
    }

    public function setUserId($value)
    {
        return $this->setParameter('userId', $value);
    }
}
