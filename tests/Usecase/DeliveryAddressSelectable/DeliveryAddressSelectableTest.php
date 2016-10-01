<?php

namespace Bws\Usecase\DeliveryAddressSelectable;

use Bws\Entity\Customer;
use Bws\Entity\CustomerStub;
use Bws\Entity\DeliveryAddressStub;
use Bws\Repository\CustomerRepositoryMock;
use Bws\Repository\DeliveryAddressRepositoryMock;

class DeliveryAddressSelectableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeliveryAddressSelectable
     */
    private $interactor;

    /**
     * @var CustomerRepositoryMock
     */
    private $customerRepository;

    /**
     * @var DeliveryAddressRepositoryMock
     */
    private $deliveryAddressRepository;

    public function setUp()
    {
        $this->customerRepository        = new CustomerRepositoryMock();
        $this->deliveryAddressRepository = new DeliveryAddressRepositoryMock();
        $this->interactor                = new DeliveryAddressSelectable($this->customerRepository, $this->deliveryAddressRepository);
    }

    public function testCustomerNotFoundShouldReturnError()
    {
        $result = $this->interactor->execute(CustomerStub::ID, DeliveryAddressStub::ID);
        $this->assertEquals($result::CUSTOMER_NOT_FOUND, $result->code);
    }

    public function testAddressNotFoundShouldReturnError()
    {
        $this->customerRepository->save(new CustomerStub());

        $result = $this->interactor->execute(CustomerStub::ID, DeliveryAddressStub::ID);

        $this->assertEquals($result::ADDRESS_NOT_FOUND, $result->code);
    }

    public function testAddressDoesNotBelongToGivenCustomerShouldReturnError()
    {
        $this->customerRepository->doSave(new CustomerStub());
        $owner = new Customer();
        $owner->setId(CustomerStub::ID + 1);
        $deliveryAddress = new DeliveryAddressStub();
        $deliveryAddress->setCustomer($owner);
        $this->deliveryAddressRepository->save($deliveryAddress);
        $hacker = new CustomerStub();

        $result = $this->interactor->execute($hacker->getId(), $deliveryAddress->getId());

        $this->assertEquals($result::ADDRESS_DOES_NOT_BELONG_TO_GIVEN_CUSTOMER, $result->code);
    }

    public function testAddressSelectableShouldReturnSelectableResultCode()
    {
        $this->customerRepository->doSave(new CustomerStub());
        $owner           = new CustomerStub();
        $deliveryAddress = new DeliveryAddressStub();
        $deliveryAddress->setCustomer($owner);
        $this->deliveryAddressRepository->save($deliveryAddress);

        $result = $this->interactor->execute($owner->getId(), $deliveryAddress->getId());

        $this->assertEquals($result::ADDRESS_IS_SELECTABLE, $result->code);
    }
}
