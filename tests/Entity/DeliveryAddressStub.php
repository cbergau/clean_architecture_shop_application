<?php

namespace Bws\Entity;

class DeliveryAddressStub extends DeliveryAddress
{
    const ID         = 887723;
    const FIRST_NAME = 'Max';
    const LAST_NAME  = 'Mustermann';
    const STREET     = 'Musterstraße 15';
    const ZIP        = '5000';
    const CITY       = 'Berlin';

    public function __construct()
    {
        $this->id = static::ID;
        $this->setFirstName(static::FIRST_NAME);
        $this->setLastName(static::LAST_NAME);
        $this->setStreet(static::STREET);
        $this->setZip(static::ZIP);
        $this->setCity(static::CITY);
    }
}
