<?php

namespace Bws\Usecase\DeliveryAddressSelectable;

use Bws\Repository\CustomerRepository;
use Bws\Repository\DeliveryAddressRepository;

class DeliveryAddressSelectable
{
    /**
     * @var \Bws\Repository\CustomerRepository
     */
    private $customerRepository;

    /**
     * @var \Bws\Repository\DeliveryAddressRepository
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
     * @param int $customerId
     * @param int $deliveryAddressId
     *
     * @return DeliveryAddressSelectableResult
     */
    public function execute($customerId, $deliveryAddressId)
    {
        $result = new DeliveryAddressSelectableResult();

        if (!$customer = $this->customerRepository->find($customerId)) {
            $result->code = $result::CUSTOMER_NOT_FOUND;
            return $result;
        }

        if (!$address = $this->deliveryAddressRepository->find($deliveryAddressId)) {
            $result->code = $result::ADDRESS_NOT_FOUND;
            return $result;
        }

        if ($address->getCustomer()->isSame($customer)) {
            $result->code = $result::ADDRESS_IS_SELECTABLE;
            return $result;
        } else {
            $result->code = $result::ADDRESS_DOES_NOT_BELONG_TO_GIVEN_CUSTOMER;
            return $result;
        }
    }
}
