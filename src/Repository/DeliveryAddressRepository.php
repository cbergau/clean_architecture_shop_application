<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\DeliveryAddress;

interface DeliveryAddressRepository
{
    /**
     * @param DeliveryAddress $deliveryAddress
     * @return void
     */
    public function save(DeliveryAddress $deliveryAddress);

    /**
     * @return DeliveryAddress
     */
    public function factory();

    /**
     * @param int $id
     *
     * @return DeliveryAddress|null
     */
    public function find($id);

    /**
     * @param string $invoiceFirstName
     * @param string $invoiceLastName
     * @param string $invoiceStreet
     * @param string $invoiceZip
     * @param string $invoiceCity
     *
     * @return DeliveryAddress|null
     */
    public function findExisting($invoiceFirstName, $invoiceLastName, $invoiceStreet, $invoiceZip, $invoiceCity);
}
