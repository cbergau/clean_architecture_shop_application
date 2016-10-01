<?php

namespace Bws\Entity;

class LogisticPartnerDHLStub extends LogisticPartner
{
    const ID = 1;

    const NAME = 'DHL';

    public function __construct()
    {
        $this->setId(self::ID);
        $this->setName(self::NAME);
    }
}
