<?php

namespace Bws\Usecase\DeliveryAddressSelectable;

use Bws\Repository\CustomerRepositoryInterface;
use Bws\Repository\DeliveryAddressRepositoryInterface;

class DeliveryAddressSelectable
{
    /**
     * @var \Bws\Repository\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var \Bws\Repository\DeliveryAddressRepositoryInterface
     */
    private $deliveryAddressRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        DeliveryAddressRepositoryInterface $deliveryAddressRepository
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
