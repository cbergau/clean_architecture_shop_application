<?php

namespace Bws\Usecase\AddDeliveryAddress;

use Bws\Entity\Customer;
use Bws\Entity\DeliveryAddress;
use Bws\Repository\CustomerRepository;
use Bws\Repository\DeliveryAddressRepository;
use Bws\Validator\DeliveryAddressValidatorFactory;

class AddDeliveryAddress
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var DeliveryAddressRepository
     */
    private $deliveryAddressRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        DeliveryAddressRepository $deliveryAddressRepository
    ) {
        $this->customerRepository        = $customerRepository;
        $this->deliveryAddressRepository = $deliveryAddressRepository;
    }

    /**
     * @param AddDeliveryAddressRequest $request
     *
     * @return AddDeliveryAddressResponse
     */
    public function execute(AddDeliveryAddressRequest $request)
    {
        $result = new AddDeliveryAddressResponse();

        if (!$customer = $this->customerRepository->find($request->customerId)) {
            $result->code = $result::CUSTOMER_NOT_FOUND;
            return $result;
        }

        $address = $this->buildAddressFromRequest($request, $customer);

        $deliveryAddressValidator = DeliveryAddressValidatorFactory::getDeliveryAddressValidator('');
        if (!$deliveryAddressValidator->isValid($address)) {
            $result->code     = $result::ADDRESS_INVALID;
            $result->messages = $deliveryAddressValidator->getMessages();
            return $result;
        }

        $this->deliveryAddressRepository->save($address);
        $result->code = $result::SUCCESS;

        return $result;
    }

    /**
     * @param AddDeliveryAddressRequest $request
     * @param Customer                  $customer
     *
     * @return DeliveryAddress
     */
    protected function buildAddressFromRequest(AddDeliveryAddressRequest $request, Customer $customer)
    {
        $address = $this->deliveryAddressRepository->factory();
        $address->setFirstName($request->firstName);
        $address->setLastName($request->lastName);
        $address->setStreet($request->street);
        $address->setZip($request->zip);
        $address->setCity($request->city);
        $address->setCustomer($customer);
        return $address;
    }
}
