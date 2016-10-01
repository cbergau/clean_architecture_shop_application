<?php

namespace Bws\Entity;

class LogisticPartnerHermesStub extends LogisticPartner
{
    const ID = 2;

    const NAME = 'Hermes';

    public function __construct()
    {
        $this->setId(self::ID);
        $this->setName(self::NAME);
    }
}
