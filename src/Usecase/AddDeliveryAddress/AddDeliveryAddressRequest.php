<?php

namespace Bws\Usecase\AddDeliveryAddress;

class AddDeliveryAddressRequest
{
    /**
     * @var int
     */
    public $customerId;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $street;

    /**
     * @var string
     */
    public $zip;

    /**
     * @var string
     */
    public $city;
}
