<?php

namespace Bws\Usecase\PresentPaymentMethods;

use Bws\Repository\PaymentMethodRepository;

class PresentPaymentMethods
{
    /**
     * @var PaymentMethodRepository
     */
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * @return PresentPaymentMethodsResponse
     */
    public function execute()
    {
        $paymentMethods = $this->paymentMethodRepository->findAll();
        $result         = array();

        foreach ($paymentMethods as $paymentMethod) {
            $result[] = array('id' => $paymentMethod->getId(), 'name' => $paymentMethod->getName());
        }

        return new PresentPaymentMethodsResponse($result);
    }
}
