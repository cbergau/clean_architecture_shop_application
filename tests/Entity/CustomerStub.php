<?php

namespace Bws\Entity;

class CustomerStub extends Customer
{
    const ID              = 12345;
    const CUSTOMER_STRING = 'CHRISTIAN-BERGAU-GRADESTRAßE15-30163-HANNOVER';
    const BIRTHDAY        = '1986-10-17';

    public function __construct()
    {
        $this->id             = static::ID;
        $this->customerString = static::CUSTOMER_STRING;
        $this->birthday       = \DateTime::createFromFormat('Y-m-d', self::BIRTHDAY);
    }
}
