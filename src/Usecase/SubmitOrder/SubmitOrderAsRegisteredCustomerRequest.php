<?php

namespace Bws\Usecase\SubmitOrder;

class SubmitOrderAsRegisteredCustomerRequest
{
    public $customerId;
    public $selectedDelivery;
    public $logisticPartnerId;
    public $paymentMethodId;
    public $basketId;
}
