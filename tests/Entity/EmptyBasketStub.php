<?php

namespace Bws\Entity;

class EmptyBasketStub extends Basket
{
    const ID = 99;

    public function __construct()
    {
        $this->setId(self::ID);
    }
}
