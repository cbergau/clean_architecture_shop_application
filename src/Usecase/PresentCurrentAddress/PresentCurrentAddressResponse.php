<?php

namespace Bws\Usecase\PresentCurrentAddress;

use Bws\Usecase\PresentLastUsedAddress\PresentLastUsedAddressResponse;

class PresentCurrentAddressResponse extends PresentLastUsedAddressResponse
{
    const DELIVERY_ADDRESS_NOT_FOUND = -4;
}
