<?php

namespace Bws\Usecase\PresentCurrentAddress;

use Bws\Repository\DeliveryAddressRepository;
use Bws\Usecase\PresentLastUsedAddress\PresentLastUsedAddress;

class PresentCurrentAddress
{
    /**
     * @var PresentLastUsedAddress
     */
    private $presentLastUsedAddress;

    /**
     * @var DeliveryAddressRepository
     */
    private $deliveryAddressRepository;

    private $lastFetchedDeliveryAddress;

    public function __construct(
        DeliveryAddressRepository $deliveryAddressRepository,
        PresentLastUsedAddress $presentLastUsedAddress
    ) {
        $this->deliveryAddressRepository = $deliveryAddressRepository;
        $this->presentLastUsedAddress    = $presentLastUsedAddress;
    }

    /**
     * @param int $customerId
     * @param int $selectedDeliveryAddressId
     *
     * @return PresentCurrentAddressResponse
     */
    public function getCurrentDeliveryAddress($customerId, $selectedDeliveryAddressId = null)
    {
        $response = new PresentCurrentAddressResponse();

        if ($selectedDeliveryAddressId) {
            $this->handleSelectedDeliveryAddress($selectedDeliveryAddressId, $response);
        } else {
            $this->handleLastUsedDeliveryAddress($customerId, $response);
        }

        return $response;
    }

    /**
     * @param integer $selectedDeliveryAddressId
     * @param PresentCurrentAddressResponse $response
     */
    protected function handleSelectedDeliveryAddress($selectedDeliveryAddressId, $response)
    {
        if (!$address = $this->deliveryAddressRepository->find($selectedDeliveryAddressId)) {
            $response->code = $response::DELIVERY_ADDRESS_NOT_FOUND;
        } else {
            $response->code                   = $response::SUCCESS;
            $response->address                = array(
                'id'        => $address->getId(),
                'firstName' => $address->getFirstName(),
                'lastName'  => $address->getLastName(),
                'street'    => $address->getStreet(),
                'zip'       => $address->getZip(),
                'city'      => $address->getCity()
            );
            $this->lastFetchedDeliveryAddress = $address;
        }
    }

    /**
     * @param integer $customerId
     * @param PresentCurrentAddressResponse $response
     */
    protected function handleLastUsedDeliveryAddress($customerId, $response)
    {
        $result                           = $this->presentLastUsedAddress->getDelivery($customerId);
        $this->lastFetchedDeliveryAddress = $this->presentLastUsedAddress->getLastFetchedDeliveryAddress();
        $response->code                   = $result->code;
        $response->address                = $result->address;
    }

    public function getLastFetchedDeliveryAddress()
    {
        return $this->lastFetchedDeliveryAddress;
    }
}
