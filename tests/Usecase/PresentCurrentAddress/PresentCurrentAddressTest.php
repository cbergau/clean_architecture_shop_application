<?php

namespace Bws\Usecase\PresentCurrentAddress;

use Bws\Entity\Customer;
use Bws\Entity\CustomerStub;
use Bws\Entity\DeliveryAddressStub;
use Bws\Repository\CustomerRepositoryMock;
use Bws\Repository\DeliveryAddressRepositoryMock;
use Bws\Usecase\PresentLastUsedAddress\PresentLastUsedAddress;

class PresentCurrentAddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CustomerRepositoryMock
     */
    private $customerRepository;

    /**
     * @var PresentCurrentAddress
     */
    private $interactor;

    /**
     * @var DeliveryAddressRepositoryMock
     */
    private $deliveryAddressRepository;

    public function setUp()
    {
        $this->customerRepository = new CustomerRepositoryMock();
        $lastUsedInteractor = new PresentLastUsedAddress($this->customerRepository);
        $this->deliveryAddressRepository = new DeliveryAddressRepositoryMock();
        $this->interactor                = new PresentCurrentAddress(
            $this->deliveryAddressRepository,
            $lastUsedInteractor
        );
    }

    public function testSelectedDeliveryAddressIdNotNullShouldReturnSelectedDeliveryAddress()
    {
        $customer = new Customer();
        $customer->setId(123);

        $selectedDeliveryAddress = new DeliveryAddressStub();
        $selectedDeliveryAddress->setCustomer($customer);

        $this->deliveryAddressRepository->save($selectedDeliveryAddress);

        $result = $this->interactor->getCurrentDeliveryAddress($customer->getId(), $selectedDeliveryAddress->getId());

        $this->assertEquals($result::SUCCESS, $result->code);
        $this->assertEquals(
            array(
                'id'        => $selectedDeliveryAddress->getId(),
                'firstName' => $selectedDeliveryAddress->getFirstName(),
                'lastName'  => $selectedDeliveryAddress->getLastName(),
                'street'    => $selectedDeliveryAddress->getStreet(),
                'zip'       => $selectedDeliveryAddress->getZip(),
                'city'      => $selectedDeliveryAddress->getCity(),
            ),
            $result->address
        );
    }

    public function testSelectedDeliveryAddressCouldNotBeFoundShouldReturnError()
    {
        $result = $this->interactor->getCurrentDeliveryAddress(CustomerStub::ID, DeliveryAddressStub::ID);
        $this->assertEquals($result::DELIVERY_ADDRESS_NOT_FOUND, $result->code);
    }

    public function testNoSelectedDeliveryAddressShouldReturnLastUsedDeliveryAddress()
    {
        $lastUsedDeliveryAddress = new DeliveryAddressStub();
        $customer = new CustomerStub();
        $customer->setLastUsedDeliveryAddress($lastUsedDeliveryAddress);
        $this->customerRepository->save($customer);

        $result = $this->interactor->getCurrentDeliveryAddress(CustomerStub::ID);
        $this->assertEquals(
            array(
                'id'        => DeliveryAddressStub::ID,
                'firstName' => DeliveryAddressStub::FIRST_NAME,
                'lastName'  => DeliveryAddressStub::LAST_NAME,
                'street'    => DeliveryAddressStub::STREET,
                'zip'       => DeliveryAddressStub::ZIP,
                'city'      => DeliveryAddressStub::CITY,
            ),
            $result->address
        );
    }
}
