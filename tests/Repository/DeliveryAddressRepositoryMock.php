<?php

namespace Bws\Repository;

use Bws\Entity\DeliveryAddress;

class DeliveryAddressRepositoryMock extends InMemoryRepository implements DeliveryAddressRepository
{
    /**
     * @var DeliveryAddress
     */
    private $lastInserted;

    /**
     * @param int $id
     *
     * @return DeliveryAddress
     */
    public function find($id)
    {
        return parent::find($id);
    }

    /**
     * @param DeliveryAddress $address
     */
    public function save(DeliveryAddress $address)
    {
        $this->doSave($address);
        $this->lastInserted = $address;
    }

    /**
     * @return DeliveryAddress
     */
    public function factory()
    {
        return new DeliveryAddress();
    }

    /**
     * @return DeliveryAddress
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }

    public function findExisting($firstName, $lastName, $street, $zip, $city)
    {
        /** @var DeliveryAddress $address */
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
