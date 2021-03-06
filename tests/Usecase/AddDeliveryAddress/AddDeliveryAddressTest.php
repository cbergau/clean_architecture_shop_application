<?php

namespace Bws\Usecase\AddDeliveryAddress;

use Bws\Entity\CustomerStub;
use Bws\Locale\Locale;
use Bws\Repository\CustomerRepositoryMock;
use Bws\Repository\DeliveryAddressRepositoryMock;

class AddDeliveryAddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CustomerRepositoryMock
     */
    private $customerRepository;

    /**
     * @var DeliveryAddressRepositoryMock
     */
    private $deliveryAddressRepository;

    /**
     * @var AddDeliveryAddress
     */
    private $interactor;

    /**
     * @var Locale
     */
    private $locale;

    public function setUp()
    {
        $this->customerRepository = new CustomerRepositoryMock();
        $this->deliveryAddressRepository = new DeliveryAddressRepositoryMock();
        $this->locale = new Locale('en', 'GB');

        $this->interactor = new AddDeliveryAddress(
            $this->customerRepository,
            $this->deliveryAddressRepository,
            $this->locale
        );
    }

    public function testCustomerNotFoundShouldReturnError()
    {
        $request = new AddDeliveryAddressRequest();
        $request->customerId = 0;

        $result = $this->interactor->execute($request);

        $this->assertEquals($result::CUSTOMER_NOT_FOUND, $result->code);
    }

    public function testAddressSavedShouldReturnSuccess()
    {
        $this->customerRepository->doSave(new CustomerStub());
        $request = new AddDeliveryAddressRequest();
        $request->customerId = CustomerStub::ID;
        $request->firstName = 'Max';
        $request->lastName = 'Mustermann';
        $request->street = 'Musterstraße 55';
        $request->city = 'Hannover';
        $request->zip = '12345';

        $result = $this->interactor->execute($request);

        $lastInserted = $this->deliveryAddressRepository->findLastInserted();

        $this->assertEquals($result::SUCCESS, $result->code);
        $this->assertEquals($request->firstName, $lastInserted->getFirstName());
        $this->assertEquals($request->lastName, $lastInserted->getLastName());
        $this->assertEquals($request->street, $lastInserted->getStreet());
        $this->assertEquals($request->zip, $lastInserted->getZip());
        $this->assertEquals($request->city, $lastInserted->getCity());
        $this->assertEquals(CustomerStub::BIRTHDAY, $lastInserted->getCustomer()->getBirthday()->format('Y-m-d'));
        $this->assertEquals(CustomerStub::CUSTOMER_STRING, $lastInserted->getCustomer()->getCustomerString());
        $this->assertEquals(CustomerStub::ID, $lastInserted->getCustomer()->getId());
    }

    public function testInvalidAddressShouldReturnAnErrorAndNotBeSaved()
    {
        $this->customerRepository->doSave(new CustomerStub());
        $request = new AddDeliveryAddressRequest();
        $request->customerId = CustomerStub::ID;
        $request->firstName = 'Max';
        $request->lastName = 'Mustermann';
        $request->street = 'Musterstraße 55';
        $request->city = 'Hannover';
        $request->zip = '999999';

        $result = $this->interactor->execute($request);

        $this->assertNull($this->deliveryAddressRepository->findLastInserted());
        $this->assertEquals($result::ADDRESS_INVALID, $result->code);
        $this->assertEquals(array('zip' => array('This field is too long')), $result->messages);
    }
}
