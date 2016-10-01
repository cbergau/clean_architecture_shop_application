<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\EmailAddress;

interface EmailAddressRepository
{
    /**
     * @return EmailAddress
     */
    public function factory();

    /**
     * @param string $address
     *
     * @return EmailAddress|null
     */
    public function findByAddress($address);

    /**
     * @return void
     */
    public function save(EmailAddress $emailAddress);
}
