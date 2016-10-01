<?php

namespace Bws\Entity;

class BasketStub extends Basket
{
    const ID = 5;

    public function __construct()
    {
        $this->setId(self::ID);
    }
}
