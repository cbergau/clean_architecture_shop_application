<?php

namespace Bws\Repository;

use Bws\Entity\EmailAddress;

class EmailAddressRepositoryMock extends InMemoryRepository implements EmailAddressRepository
{
    /**
     * @var EmailAddress
     */
    private $lastInserted;

    /**
     * @return EmailAddress
     */
    public function factory()
    {
        return new EmailAddress();
    }

    public function save(EmailAddress $emailAddress)
    {
        parent::doSave($emailAddress);
        $this->lastInserted = $emailAddress;
    }

    /**
     * @return EmailAddress
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }

    /**
     * @param string $address
     *
     * @return EmailAddress|null
     */
    public function findByAddress($address)
    {
        /** @var EmailAddress $emailAddress */
        foreach ($this->getEntities() as $emailAddress) {
            if ($emailAddress->getAddress() == $address) {
                return $emailAddress;
            }
        }

        return;
    }
}
