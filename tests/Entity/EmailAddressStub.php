<?php

namespace Bws\Entity;

class EmailAddressStub extends EmailAddress
{
    const ID = 5566;
    const ADDRESS = 'cbergau86@googlemail.com';

    public function __construct()
    {
        $this->id = static::ID;
        $this->address = static::ADDRESS;
        $this->customer = new CustomerStub();
    }
}
