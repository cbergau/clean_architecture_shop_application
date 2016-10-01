<?php

namespace Bws\Usecase\ChangeInvoiceAddress;

use Bws\Entity\CustomerStub;
use Bws\Repository\CustomerRepositoryMock;
use Bws\Repository\InvoiceAddressRepositoryMock;

class ChangeInvoiceAddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CustomerRepositoryMock
     */
    private $customerRepository;

    /**
     * @var InvoiceAddressRepositoryMock
     */
    private $invoiceAddressRepository;

    /**
     * @var ChangeInvoiceAddress
     */
    private $interactor;

    public function setUp()
    {
        $this->customerRepository       = new CustomerRepositoryMock();
        $this->invoiceAddressRepository = new InvoiceAddressRepositoryMock();
        $this->interactor               = new ChangeInvoiceAddress($this->customerRepository, $this->invoiceAddressRepository);
    }

    public function testCustomerNotFoundShouldReturnError()
    {
        $request             = new ChangeInvoiceAddressRequest();
        $request->customerId = CustomerStub::ID;

        $result = $this->interactor->execute($request);

        $this->assertEquals($result::CUSTOMER_NOT_FOUND, $result->code);
    }

    public function testSavesNewAddressAndSetsCustomersLastUsed()
    {
        $this->customerRepository->doSave(new CustomerStub());
        $request             = new ChangeInvoiceAddressRequest();
        $request->customerId = CustomerStub::ID;
        $request->firstName  = 'Max';
        $request->lastName   = 'Mustermann';
        $request->street     = 'Musterstraße 15';
        $request->zip        = '30163';
        $request->city       = 'Hannover';

        $result = $this->interactor->execute($request);

        $lastInserted = $this->invoiceAddressRepository->findLastInserted();
        $this->assertEquals($result::SUCCESS, $result->code);
        $this->assertEquals($request->firstName, $lastInserted->getFirstName());
        $this->assertEquals($request->lastName, $lastInserted->getLastName());
        $this->assertEquals($request->street, $lastInserted->getStreet());
        $this->assertEquals($request->zip, $lastInserted->getZip());
        $this->assertEquals($request->city, $lastInserted->getCity());
        $this->assertEquals($request->customerId, $lastInserted->getCustomer()->getId());
    }
}
