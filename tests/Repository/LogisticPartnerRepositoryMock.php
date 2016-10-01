<?php

namespace Bws\Repository;

use Bws\Entity\LogisticPartner;

class LogisticPartnerRepositoryMock extends InMemoryRepository implements LogisticPartnerRepository
{
    const DHL_ID = 1;
    const HERMES_ID = 2;

    /**
     * @return LogisticPartner[]
     */
    public function findAll()
    {
        return $this->getEntities();
    }

    /**
     * @param int $id
     *
     * @return LogisticPartner
     */
    public function find($id)
    {
        /** @var LogisticPartner $logisticPartner */
        foreach ($this->getEntities() as $logisticPartner) {
            if ($logisticPartner->getId() == $id) {
                return $logisticPartner;
            }
        }

        return;
    }
}
