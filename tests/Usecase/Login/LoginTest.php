<?php

namespace Bws\Usecase\Login;

use Bws\Entity\CustomerStub;
use Bws\Entity\EmailAddressStub;
use Bws\Entity\InvoiceAddressStub;
use Bws\Repository\EmailAddressRepositoryMock;

class LoginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EmailAddressRepositoryMock
     */
    private $emailRepository;

    /**
     * @var Login
     */
    private $interactor;

    public function setUp()
    {
        $this->emailRepository = new EmailAddressRepositoryMock();
        $this->interactor      = new Login($this->emailRepository);
    }

    public function testLoginWithNonExistingEmailAddressShouldReturnAnError()
    {
        $response = $this->interactor->execute('doesnot@exist.com', '1999-01-02');
        $this->assertEquals($response::WRONG_EMAIL_ADDRESS, $response->code);
    }

    public function testLoginWithWrongBirthdayIfPasswordIsNotSet()
    {
        $this->emailRepository->save(new EmailAddressStub());
        $response = $this->interactor->execute(EmailAddressStub::ADDRESS, '1999-01-02');
        $this->assertEquals($response::WRONG_PASSWORD_BIRTHDAY, $response->code);
    }

    public function testLoginWithPasswordShouldNotAcceptBirthday()
    {
        $customer = new CustomerStub();
        $customer->setPassword(md5(123));
        $customer->setBirthday(\DateTime::createFromFormat('Y-m-d', '1986-10-12'));

        $email = new EmailAddressStub();
        $email->setCustomer($customer);
        $email->setAddress('test@gmail.com');

        $this->emailRepository->save($email);

        $response = $this->interactor->execute('test@gmail.com', '1986-10-12');

        $this->assertEquals($response::WRONG_PASSWORD_BIRTHDAY, $response->code);
    }

    public function testLoginWithCustomerWhoHasNoPasswordShouldAcceptBirthdayAsThePassword()
    {
        $customer = new CustomerStub();
        $customer->setPassword(null);
        $customer->setBirthday(\DateTime::createFromFormat('Y-m-d', '1986-10-12'));

        $invoice = new InvoiceAddressStub();
        $customer->setLastUsedInvoiceAddress($invoice);

        $email = new EmailAddressStub();
        $email->setCustomer($customer);
        $email->setAddress('test@gmail.com');

        $this->emailRepository->save($email);

        $response = $this->interactor->execute('test@gmail.com', '1986-10-12');

        $this->assertEquals($response::SUCCESS, $response->code);
        $this->assertEquals(InvoiceAddressStub::FIRST_NAME.' '.InvoiceAddressStub::LAST_NAME, $response->display);
    }

    public function testLoginWithCustomerWhoHasPasswordShouldAcceptThePassword()
    {
        $customer = new CustomerStub();
        $customer->setPassword(md5(123));
        $customer->setBirthday(\DateTime::createFromFormat('Y-m-d', '1986-10-12'));

        $invoice = new InvoiceAddressStub();
        $customer->setLastUsedInvoiceAddress($invoice);

        $email = new EmailAddressStub();
        $email->setCustomer($customer);
        $email->setAddress('test@gmail.com');

        $this->emailRepository->save($email);

        $response = $this->interactor->execute('test@gmail.com', 123);

        $this->assertEquals($response::SUCCESS, $response->code);
        $this->assertEquals(InvoiceAddressStub::FIRST_NAME.' '.InvoiceAddressStub::LAST_NAME, $response->display);
    }
}
