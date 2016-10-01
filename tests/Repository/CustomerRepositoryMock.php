<?php

namespace Bws\Repository;

use Bws\Entity\Customer;
use Bws\Entity\CustomerStub;
use Bws\Entity\InvoiceAddress;

class CustomerRepositoryMock extends InMemoryRepository implements CustomerRepository
{
    /**
     * @var Customer
     */
    private $lastInserted;

    /**
     * @var InvoiceAddress
     */
    private $matchedInvoice;

    /**
     * @return Customer
     */
    public function factory()
    {
        return new CustomerStub();
    }

    public function save(Customer $customer)
    {
        parent::doSave($customer);
        $this->lastInserted = $customer;
    }

    /**
     * @return Customer
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }

    /**
     * @param InvoiceAddress $invoiceAddress
     *
     * @return Customer|null
     */
    public function match(InvoiceAddress $invoiceAddress)
    {
        /** @var Customer $customer */
        foreach ($this->getEntities() as $customer) {
            if ($customer->getCustomerString() == $invoiceAddress->getCustomerString()) {
                $this->matchedInvoice = $invoiceAddress;

                return $customer;
            }
        }

        return;
    }

    /**
     * @return InvoiceAddress
     */
    public function getMatchedInvoice()
    {
        return $this->matchedInvoice;
    }

    /**
     * @param $customerId
     *
     * @return Customer|null
     */
    public function find($customerId)
    {
        return parent::find($customerId);
    }
}
