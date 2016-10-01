<?php

namespace Bws\Usecase\DeliveryAddressSelectable;

class DeliveryAddressSelectableResult
{
    const ADDRESS_IS_SELECTABLE = 1;
    const CUSTOMER_NOT_FOUND = -1;
    const ADDRESS_NOT_FOUND = -2;
    const ADDRESS_DOES_NOT_BELONG_TO_GIVEN_CUSTOMER = -3;

    /**
     * @var int
     */
    public $code;
}
