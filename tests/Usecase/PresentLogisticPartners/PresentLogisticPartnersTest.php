<?php

namespace Bws\Usecase\PresentLogisticPartners;

use Bws\Entity\LogisticPartnerDHLStub;
use Bws\Entity\LogisticPartnerHermesStub;
use Bws\Repository\LogisticPartnerRepositoryMock;

class PresentLogisticPartnersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PresentLogisticPartners
     */
    private $interactor;

    /**
     * @var LogisticPartnerRepositoryMock
     */
    private $logisticPartnerRepository;

    public function setUp()
    {
        $this->logisticPartnerRepository = new LogisticPartnerRepositoryMock();
        $this->logisticPartnerRepository->doSave(new LogisticPartnerDHLStub());
        $this->logisticPartnerRepository->doSave(new LogisticPartnerHermesStub());

        $this->interactor = new PresentLogisticPartners($this->logisticPartnerRepository);
    }

    public function testReturnsLogisticPartners()
    {
        $response = $this->interactor->execute();

        $this->assertEquals(
            array(
                array(
                    'id'   => LogisticPartnerDHLStub::ID,
                    'name' => LogisticPartnerDHLStub::NAME,
                ),
                array(
                    'id'   => LogisticPartnerHermesStub::ID,
                    'name' => LogisticPartnerHermesStub::NAME,
                ),
            ),
            $response->getLogisticPartners()
        );
    }
}
