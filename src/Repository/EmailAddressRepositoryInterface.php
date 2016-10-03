<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\EmailAddress;

interface EmailAddressRepositoryInterface
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
     * @param EmailAddress $emailAddress
     *
     * @return void
     */
    public function save(EmailAddress $emailAddress);
}
