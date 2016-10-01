<?php

namespace Bws\Entity;

class InvoiceAddress extends Address
{
    public function getCustomerString()
    {
        return sprintf(
            '%s-%s-%s-%s-%s',
            $this->filterForCustomerString($this->getFirstName()),
            $this->filterForCustomerString($this->getLastName()),
            $this->filterForCustomerString($this->getStreet()),
            $this->filterForCustomerString($this->getZip()),
            $this->filterForCustomerString($this->getCity())
        );
    }

    /**
     * @param string $input
     *
     * @return string
     */
    private function filterForCustomerString($input)
    {
        return preg_replace('/\s/', '', strtoupper($input));
    }
}
