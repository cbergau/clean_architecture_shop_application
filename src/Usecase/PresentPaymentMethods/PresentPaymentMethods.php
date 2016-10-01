<?php

namespace Bws\Usecase\PresentPaymentMethods;

use Bws\Repository\PaymentMethodRepositoryInterface;

class PresentPaymentMethods
{
    /**
     * @var PaymentMethodRepositoryInterface
     */
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
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
