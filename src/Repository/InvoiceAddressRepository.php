<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\InvoiceAddress;

interface InvoiceAddressRepository
{
    /**
     * @param InvoiceAddress $invoiceAddress
     * @return void
     */
    public function save(InvoiceAddress $invoiceAddress);

    /**
     * @return InvoiceAddress
     */
    public function factory();

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $street
     * @param string $zip
     * @param string $city
     *
     * @return InvoiceAddress|null
     */
    public function findExisting($firstName, $lastName, $street, $zip, $city);
}
