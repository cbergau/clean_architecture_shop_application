<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\InvoiceAddress;
use Bws\Entity\Customer;

interface CustomerRepository
{
    /**
     * @return Customer
     */
    public function factory();

    /**
     * @param $customerId
     *
     * @return Customer|null
     */
    public function find($customerId);

    /**
     * @param InvoiceAddress $invoiceAddress
     *
     * @return Customer|null
     */
    public function match(InvoiceAddress $invoiceAddress);

    /**
     * @param Customer $customer
     *
     * @return void
     */
    public function save(Customer $customer);
}
