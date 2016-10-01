<?php

namespace Bws\Usecase\PresentLogisticPartners;

use Bws\Repository\LogisticPartnerRepositoryInterface;

class PresentLogisticPartners
{
    /**
     * @var LogisticPartnerRepositoryInterface
     */
    private $logisticPartnerRepository;

    public function __construct(LogisticPartnerRepositoryInterface $logisticPartnerRepository)
    {
        $this->logisticPartnerRepository = $logisticPartnerRepository;
    }

    /**
     * @return PresentLogisticPartnersResponse
     */
    public function execute()
    {
        $logisticPartners = $this->logisticPartnerRepository->findAll();
        $result           = array();

        foreach ($logisticPartners as $logisticPartner) {
            $result[] = array('id' => $logisticPartner->getId(), 'name' => $logisticPartner->getName());
        }

        return new PresentLogisticPartnersResponse($result);
    }
}
