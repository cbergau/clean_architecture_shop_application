<?php

namespace Bws\Entity;

class EmailAddress extends Entity
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * Set address
     *
     * @param string $address
     *
     * @return EmailAddress
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set customer
     *
     * @param Customer $customer
     *
     * @return EmailAddress
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
