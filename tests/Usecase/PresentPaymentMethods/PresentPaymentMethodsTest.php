<?php

namespace Bws\Usecase\PresentPaymentMethods;

use Bws\Entity\PaymentMethodCashOnDeliveryStub;
use Bws\Entity\PaymentMethodInvoiceStub;
use Bws\Repository\PaymentMethodRepositoryMock;

class PresentPaymentMethodsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PresentPaymentMethods
     */
    private $interactor;

    /**
     * @var PaymentMethodRepositoryMock
     */
    private $paymentRepository;

    public function setUp()
    {
        $this->paymentRepository = new PaymentMethodRepositoryMock();
        $this->interactor        = new PresentPaymentMethods($this->paymentRepository);
    }

    public function testReturnsPaymentMethods()
    {
        $this->paymentRepository->doSave(new PaymentMethodInvoiceStub());
        $this->paymentRepository->doSave(new PaymentMethodCashOnDeliveryStub());

        $paymentMethods = $this->paymentRepository->findAll();
        $response       = $this->interactor->execute();

        $this->assertEquals(
            array(
                array(
                    'id'   => $paymentMethods[PaymentMethodInvoiceStub::ID]->getId(),
                    'name' => $paymentMethods[PaymentMethodInvoiceStub::ID]->getName(),
                ),
                array(
                    'id'   => $paymentMethods[PaymentMethodCashOnDeliveryStub::ID]->getId(),
                    'name' => $paymentMethods[PaymentMethodCashOnDeliveryStub::ID]->getName(),
                ),
            ),
            $response->getPaymentMethods()
        );
    }
}
