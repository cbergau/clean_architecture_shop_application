<?php

namespace Bws\Entity;

class PaymentMethodCashOnDeliveryStub extends PaymentMethod
{
    const ID = 6;
    const NAME = 'CashOnDelivery';

    public function __construct()
    {
        $this->setId(self::ID);
        $this->setName(self::NAME);
    }
}
