<?php

namespace Bws\Usecase\SubmitOrder;

class SubmitOrderAsUnregisteredCustomerRequest
{
    /**
     * @var string
     */
    public $invoiceFirstName;

    /**
     * @var string
     */
    public $invoiceLastName;

    /**
     * @var string
     */
    public $invoiceStreet;

    /**
     * @var string
     */
    public $invoiceZip;

    /**
     * @var string
     */
    public $invoiceCity;

    /**
     * @var string
     */
    public $emailAddress;

    /**
     * @var string
     */
    public $deliveryFirstName;

    /**
     * @var string
     */
    public $deliveryLastName;

    /**
     * @var string
     */
    public $deliveryStreet;

    /**
     * @var string
     */
    public $deliveryZip;

    /**
     * @var string
     */
    public $deliveryCity;

    /**
     * @var int
     */
    public $paymentMethodId;

    /**
     * @var int
     */
    public $logisticPartnerId;

    /**
     * @var int
     */
    public $basketId;

    /**
     * @var bool
     */
    public $registering;

    /**
     * Format: Y-m-d for example: 1986-10-17
     *
     * @var string
     */
    public $birthday;
}
