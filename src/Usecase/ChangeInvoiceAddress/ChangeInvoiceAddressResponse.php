<?php

namespace Bws\Usecase\ChangeInvoiceAddress;

class ChangeInvoiceAddressResponse
{
    const SUCCESS = 1;
    const FAILURE = 0;
    const CUSTOMER_NOT_FOUND = -1;

    /**
     * @var int
     */
    public $code = 0;

    /**
     * @var int
     */
    public $addressId;
}
