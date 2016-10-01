<?php

namespace Bws\Repository;

use Bws\Entity\InvoiceAddress;

class InvoiceAddressRepositoryMock extends InMemoryRepository implements InvoiceAddressRepository
{
    /**
     * @var InvoiceAddress
     */
    private $lastInserted;

    /**
     * @param int $id
     *
     * @return InvoiceAddress
     */
    public function find($id)
    {
        return parent::find($id);
    }

    /**
     * @param InvoiceAddress $address
     */
    public function save(InvoiceAddress $address)
    {
        parent::doSave($address);
        $this->lastInserted = $address;
    }

    /**
     * @return InvoiceAddress
     */
    public function factory()
    {
        return new InvoiceAddress();
    }

    /**
     * @return InvoiceAddress
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }

    public function findExisting($firstName, $lastName, $street, $zip, $city)
    {
        /** @var InvoiceAddress $address */
        foreach ($this->getEntities() as $address) {
            if ($address->getFirstName() == $firstName
                && $address->getLastName() == $lastName
                && $address->getStreet() == $street
                && $address->getZip() == $zip
                && $address->getCity() == $city
            ) {
                return $address;
            }
        }

        return;
    }
}
