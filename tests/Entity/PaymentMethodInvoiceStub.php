<?php

namespace Bws\Entity;

class PaymentMethodInvoiceStub extends PaymentMethod
{
    const ID = 5;
    const NAME = 'Invoice';

    public function __construct()
    {
        $this->setId(self::ID);
        $this->setName(self::NAME);
    }
}
