<?php

namespace Bws\Usecase\PresentLastUsedAddress;

class PresentLastUsedAddressResponse
{
    const SUCCESS = 1;
    const CUSTOMER_NOT_FOUND = -1;
    const CUSTOMER_HAS_NO_LAST_USED_INVOICE_ADDRESS = -2;
    const CUSTOMER_HAS_NO_LAST_USED_DELIVERY_ADDRESS = -3;

    /**
     * @var int
     */
    public $code;

    /**
     * @var array
     */
    public $address;
}
