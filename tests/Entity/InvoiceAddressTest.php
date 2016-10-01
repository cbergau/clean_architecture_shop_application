<?php

namespace Bws\Entity;

class InvoiceAddressTest extends \PHPUnit_Framework_TestCase
{
    public function testCustomerStringShouldReturnWhitespacesRemovedAndUpperCase()
    {
        $invoiceAddress = new InvoiceAddress();
        $invoiceAddress->setFirstName('Christian ');
        $invoiceAddress->setLastName(' Bergau');
        $invoiceAddress->setStreet('Gradestraße 15');
        $invoiceAddress->setCity(' Hannover ');
        $invoiceAddress->setZip('30163');

        $this->assertEquals('CHRISTIAN-BERGAU-GRADESTRAßE15-30163-HANNOVER', $invoiceAddress->getCustomerString());
    }
}
