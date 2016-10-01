<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\LogisticPartner;

interface LogisticPartnerRepository
{
    /**
     * @return LogisticPartner[]
     */
    public function findAll();

    /**
     * @param int $id
     *
     * @return LogisticPartner
     */
    public function find($id);
}
