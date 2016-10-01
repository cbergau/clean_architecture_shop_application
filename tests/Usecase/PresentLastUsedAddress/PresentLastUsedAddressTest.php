<?php

namespace Bws\Usecase\PresentLastUsedAddress;

use Bws\Entity\CustomerStub;
use Bws\Entity\InvoiceAddressStub;
use Bws\Repository\CustomerRepositoryMock;

class PresentLastUsedAddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CustomerRepositoryMock
     */
    private $customerRepository;

    /**
     * @var PresentLastUsedAddress
     */
    private $interactor;

    public function setUp()
    {
        $this->customerRepository = new CustomerRepositoryMock();
        $this->interactor         = new PresentLastUsedAddress($this->customerRepository);
    }

    public function testCustomerNotFoundShouldReturnError()
    {
        $result = $this->interactor->getInvoice(9999);
        $this->assertEquals($result::CUSTOMER_NOT_FOUND, $result->code);
    }

    public function testPresentLastUsedInvoiceAddressNotFoundShouldReturnError()
    {
        $customerWithoutInvoice = new CustomerStub();
        $customerWithoutInvoice->setLastUsedInvoiceAddress(null);
        $this->customerRepository->save($customerWithoutInvoice);

        $result = $this->interactor->getInvoice($customerWithoutInvoice->getId());

        $this->assertEquals($result::CUSTOMER_HAS_NO_LAST_USED_INVOICE_ADDRESS, $result->code);
    }

    public function testPresentLastUsedDeliveryAddressNotFoundShouldReturnError()
    {
        $customerWithoutInvoice = new CustomerStub();
        $customerWithoutInvoice->setLastUsedDeliveryAddress(null);
        $this->customerRepository->save($customerWithoutInvoice);

        $result = $this->interactor->getDelivery($customerWithoutInvoice->getId());

        $this->assertEquals($result::CUSTOMER_HAS_NO_LAST_USED_DELIVERY_ADDRESS, $result->code);
    }

    public function testPresentLastUsedInvoiceAddressShouldReturnPresentableAddress()
    {
        $customerWithInvoice = new CustomerStub();
        $customerWithInvoice->setLastUsedInvoiceAddress(new InvoiceAddressStub());

        $this->customerRepository->save($customerWithInvoice);

        $result = $this->interactor->getInvoice($customerWithInvoice->getId());

        $this->assertEquals($result::SUCCESS, $result->code);
        $this->assertEquals(InvoiceAddressStub::ID, $result->address['id']);
        $this->assertEquals(InvoiceAddressStub::FIRST_NAME, $result->address['firstName']);
        $this->assertEquals(InvoiceAddressStub::LAST_NAME, $result->address['lastName']);
        $this->assertEquals(InvoiceAddressStub::STREET, $result->address['street']);
        $this->assertEquals(InvoiceAddressStub::ZIP, $result->address['zip']);
        $this->assertEquals(InvoiceAddressStub::CITY, $result->address['city']);
    }
}
