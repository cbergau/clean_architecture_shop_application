<?php

namespace Bws\Usecase\AddDeliveryAddress;

use Bws\Entity\Customer;
use Bws\Entity\DeliveryAddress;
use Bws\Locale\Locale;
use Bws\Repository\CustomerRepositoryInterface;
use Bws\Repository\DeliveryAddressRepositoryInterface;
use Bws\Validator\DeliveryAddressValidatorFactory;

class AddDeliveryAddress
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var DeliveryAddressRepositoryInterface
     */
    private $deliveryAddressRepository;

    /**
     * @var Locale
     */
    private $locale;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        DeliveryAddressRepositoryInterface $deliveryAddressRepository,
        Locale $locale
    ) {
        $this->customerRepository = $customerRepository;
        $this->deliveryAddressRepository = $deliveryAddressRepository;
        $this->locale = $locale;
    }

    /**
     * @param AddDeliveryAddressRequest $request
     *
     * @return AddDeliveryAddressResponse
     */
    public function execute(AddDeliveryAddressRequest $request)
    {
        $response = new AddDeliveryAddressResponse();

        if (!$customer = $this->customerRepository->find($request->customerId)) {
            $response->code = $response::CUSTOMER_NOT_FOUND;
            return $response;
        }

        $address = $this->buildAddressFromRequest($request, $customer);

        $deliveryAddressValidator = DeliveryAddressValidatorFactory::getDeliveryAddressValidator($this->locale);

        if (!$deliveryAddressValidator->isValid($address)) {
            $response->code = $response::ADDRESS_INVALID;
            $response->messages = $deliveryAddressValidator->getMessages();
            return $response;
        }

        $this->deliveryAddressRepository->save($address);
        $response->code = $response::SUCCESS;

        return $response;
    }

    /**
     * @param AddDeliveryAddressRequest $request
     * @param Customer $customer
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
