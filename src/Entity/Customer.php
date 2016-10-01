<?php

namespace Bws\Entity;

class Customer extends Entity
{
    /**
     * @var bool
     */
    protected $isRegistered = false;

    /**
     * @var InvoiceAddress
     */
    protected $lastUsedInvoiceAddress;

    /**
     * @var EmailAddress
     */
    protected $lastUsedEmailAddress;

    /**
     * @var DeliveryAddress
     */
    protected $lastUsedDeliveryAddress;

    /**
     * @var string
     */
    protected $customerString;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \DateTime
     */
    protected $birthday;

    /**
     * @return bool
     */
    public function isRegistered()
    {
        return $this->isRegistered;
    }

    public function register()
    {
        $this->isRegistered = true;
    }

    /**
     * Set lastUsedInvoiceAddress
     *
     * @param InvoiceAddress $lastUsedInvoiceAddress
     *
     * @return Customer
     */
    public function setLastUsedInvoiceAddress(InvoiceAddress $lastUsedInvoiceAddress = null)
    {
        $this->lastUsedInvoiceAddress = $lastUsedInvoiceAddress;

        return $this;
    }

    /**
     * @param InvoiceAddress $address
     *
     * @return $this
     */
    public function changeCurrentInvoiceAddress(InvoiceAddress $address)
    {
        $this->lastUsedInvoiceAddress = $address;

        return $this;
    }

    /**
     * Get lastUsedInvoiceAddress
     *
     * @return InvoiceAddress
     */
    public function getLastUsedInvoiceAddress()
    {
        return $this->lastUsedInvoiceAddress;
    }

    /**
     * Set lastUsedEmailAddress
     *
     * @param EmailAddress $lastUsedEmailAddress
     *
     * @return Customer
     */
    public function setLastUsedEmailAddress(EmailAddress $lastUsedEmailAddress = null)
    {
        $this->lastUsedEmailAddress = $lastUsedEmailAddress;

        return $this;
    }

    /**
     * Get lastUsedEmailAddress
     *
     * @return EmailAddress
     */
    public function getLastUsedEmailAddress()
    {
        return $this->lastUsedEmailAddress;
    }

    /**
     * Set lastUsedDeliveryAddress
     *
     * @param DeliveryAddress $lastUsedDeliveryAddress
     *
     * @return Customer
     */
    public function setLastUsedDeliveryAddress(DeliveryAddress $lastUsedDeliveryAddress = null)
    {
        $this->lastUsedDeliveryAddress = $lastUsedDeliveryAddress;

        return $this;
    }

    /**
     * Get lastUsedDeliveryAddress
     *
     * @return DeliveryAddress
     */
    public function getLastUsedDeliveryAddress()
    {
        return $this->lastUsedDeliveryAddress;
    }

    /**
     * @param string $customerString
     */
    public function setCustomerString($customerString)
    {
        $this->customerString = $customerString;
    }

    /**
     * @return string
     */
    public function getCustomerString()
    {
        return $this->customerString;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    public function isSame(Customer $customerTwo)
    {
        return $this->getId() == $customerTwo->getId();
    }
}
