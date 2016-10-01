<?php

namespace Bws\Usecase\PresentLastUsedAddress;

use Bws\Entity\DeliveryAddressStub;
use Bws\Entity\InvoiceAddressStub;

class PresentLastUsedAddressStub extends PresentLastUsedAddress
{
    public function __construct()
    {
    }

    public function getInvoice($customerId)
    {
        return new InvoiceAddressStub();
    }

    public function getDelivery($customerId)
    {
        return new DeliveryAddressStub();
    }
}
