<?php

namespace Bws\Usecase\AddDeliveryAddress;

class AddDeliveryAddressResponse
{
    const SUCCESS = 1;

    const CUSTOMER_NOT_FOUND = -1;
    const ADDRESS_INVALID    = -2;

    /**
     * @var int
     */
    public $code;

    public $messages = array();
}
