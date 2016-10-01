<?php

namespace Bws\Entity;

class Order extends Entity
{
    /**
     * @var InvoiceAddress
     */
    protected $invoiceAddress;

    /**
     * @var DeliveryAddress
     */
    protected $deliveryAddress;

    /**
     * @var Basket
     */
    protected $basket;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var EmailAddress
     */
    protected $emailAddress;

    /**
     * @var LogisticPartner
     */
    protected $logisticPartner;

    /**
     * @var PaymentMethod
     */
    protected $paymentMethod;

    /**
     * Set invoiceAddress
     *
     * @param InvoiceAddress $invoiceAddress
     *
     * @return Order
     */
    public function setInvoiceAddress(InvoiceAddress $invoiceAddress = null)
    {
        $this->invoiceAddress = $invoiceAddress;

        return $this;
    }

    /**
     * Get invoiceAddress
     *
     * @return InvoiceAddress
     */
    public function getInvoiceAddress()
    {
        return $this->invoiceAddress;
    }

    /**
     * Set deliveryAddress
     *
     * @param DeliveryAddress $deliveryAddress
     *
     * @return Order
     */
    public function setDeliveryAddress(DeliveryAddress $deliveryAddress = null)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get deliveryAddress
     *
     * @return DeliveryAddress
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Set basket
     *
     * @param Basket $basket
     *
     * @return Order
     */
    public function setBasket(Basket $basket = null)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return Basket
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set customer
     *
     * @param Customer $customer
     *
     * @return Order
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

    /**
     * Set emailAddress
     *
     * @param EmailAddress $emailAddress
     *
     * @return Order
     */
    public function setEmailAddress(EmailAddress $emailAddress = null)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return EmailAddress
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set logisticPartner
     *
     * @param LogisticPartner $logisticPartner
     *
     * @return Order
     */
    public function setLogisticPartner(LogisticPartner $logisticPartner = null)
    {
        $this->logisticPartner = $logisticPartner;

        return $this;
    }

    /**
     * Get logisticPartner
     *
     * @return LogisticPartner
     */
    public function getLogisticPartner()
    {
        return $this->logisticPartner;
    }

    /**
     * Set paymentMethod
     *
     * @param PaymentMethod $paymentMethod
     *
     * @return Order
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod = null)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }
}
