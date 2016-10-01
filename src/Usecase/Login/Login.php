<?php

namespace Bws\Usecase\Login;

use Bws\Entity\Customer;
use Bws\Repository\EmailAddressRepository;

class Login
{
    /**
     * @var EmailAddressRepository
     */
    private $emailRepository;

    /**
     * @param EmailAddressRepository $emailRepository
     */
    public function __construct(EmailAddressRepository $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return LoginResponse
     */
    public function execute($email, $password)
    {
        $response = new LoginResponse();

        if (!$email = $this->emailRepository->findByAddress($email)) {
            $response->code       = LoginResponse::WRONG_EMAIL_ADDRESS;
            $response->messages[] = 'Please check your e-mail address again';
            return $response;
        }

        $customer = $email->getCustomer();

        if ($this->customerPasswordShouldBeHisBirthday($customer)) {
            $this->validateBirthdayPassword($password, $customer, $response);
        } else {
            $this->validateRealPassword($password, $customer, $response);
        }

        return $response;
    }

    /**
     * @param Customer $customer
     *
     * @return bool
     */
    protected function customerPasswordShouldBeHisBirthday(Customer $customer)
    {
        return $customer->getPassword() === null;
    }

    /**
     * @param string        $password
     * @param Customer      $customer
     * @param LoginResponse $response
     */
    protected function validateBirthdayPassword($password, Customer $customer, LoginResponse $response)
    {
        if ($password != $customer->getBirthday()->format('Y-m-d')) {
            $response->code       = LoginResponse::WRONG_PASSWORD_BIRTHDAY;
            $response->messages[] = 'Your initial password is the birthday in format yyyy-mm-dd';
        } else {
            $invoice              = $customer->getLastUsedInvoiceAddress();
            $response->code       = LoginResponse::SUCCESS;
            $response->customerId = $customer->getId();
            $response->display    = $invoice->getFirstName() . ' ' . $invoice->getLastName();
        }
    }

    /**
     * @param string        $password
     * @param Customer      $customer
     * @param LoginResponse $response
     */
    protected function validateRealPassword($password, Customer $customer, LoginResponse $response)
    {
        if ($customer->getPassword() != md5($password)) {
            $response->code       = LoginResponse::WRONG_PASSWORD_BIRTHDAY;
            $response->messages[] = 'Your password is wrong';
        } else {
            $invoice              = $customer->getLastUsedInvoiceAddress();
            $response->code       = LoginResponse::SUCCESS;
            $response->customerId = $customer->getId();
            $response->display    = $invoice->getFirstName() . ' ' . $invoice->getLastName();
        }
    }
}
