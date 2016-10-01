<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Validator;

interface ValidatorInterface
{
    /**
     * @return boolean
     */
    public function isValid($value);

    /**
     * @return array
     */
    public function getMessages();
}
