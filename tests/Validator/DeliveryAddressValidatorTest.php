<?php

namespace Bws\Validator;

use Bws\Entity\DeliveryAddress;
use Symfony\Component\Yaml\Yaml;

class DeliveryAddressValidatorTest extends \PHPUnit_Framework_TestCase
{
    private static $config;

    public static function setUpBeforeClass()
    {
        self::$config = Yaml::parse(file_get_contents(__DIR__ . '/../../src/Validator/Rules/delivery_address.yml'));
    }

    public function invalidAddressesProvider()
    {
        return array(
            array('DE', 'Max', 'Muster', 'Musterstr 1', '123456', 'Hannover', array('zip' => array('STRING_TOO_LONG'))),
            array('DE', 'Max', 'Muster', 'Musterstr 2', '1', 'Hannover', array('zip' => array('STRING_TOO_SHORT'))),
            array(
                'DE',
                'M',
                'Muster',
                'Musterstr 2',
                '1',
                'Hannover',
                array('firstName' => array('STRING_TOO_SHORT'), 'zip' => array('STRING_TOO_SHORT')),
            ),
        );
    }

    /**
     * @dataProvider invalidAddressesProvider
     */
    public function testInvalidAddresses($region, $firstName, $lastName, $street, $zip, $city, $messages)
    {
        $validator = new DeliveryAddressValidator($region, self::$config);

        $address = new DeliveryAddress();
        $address->setFirstName($firstName);
        $address->setLastName($lastName);
        $address->setStreet($street);
        $address->setZip($zip);
        $address->setCity($city);

        $this->assertFalse($validator->isValid($address));
        $this->assertEquals($messages, $validator->getMessages());
    }

    public function validAddressesProvider()
    {
        return array(
            array('DE', 'Max', 'Muster', 'Musterstr 1', '30655', 'Hannover'),
        );
    }

    /**
     * @dataProvider validAddressesProvider
     */
    public function testValidAddresses($region, $firstName, $lastName, $street, $zip, $city)
    {
        $validator = new DeliveryAddressValidator($region, self::$config);

        $address = new DeliveryAddress();
        $address->setFirstName($firstName);
        $address->setLastName($lastName);
        $address->setStreet($street);
        $address->setZip($zip);
        $address->setCity($city);

        $this->assertTrue($validator->isValid($address));
        $this->assertEquals(array(), $validator->getMessages());
    }

    public function testValidatingTwoTimesShouldResetErrorMessages()
    {
        $validator = new DeliveryAddressValidator('DE', self::$config);

        $address = new DeliveryAddress();
        $address->setFirstName('M');
        $address->setLastName('Muster');
        $address->setStreet('Musterstr 1');
        $address->setZip('30655');
        $address->setCity('Hannover');

        $validator->isValid($address);
        $validator->isValid($address);

        $this->assertEquals(array('firstName' => array('STRING_TOO_SHORT')), $validator->getMessages());
    }

    public function testValidatingTwoTimesWithDifferentErrorsShouldResetErrorMessages()
    {
        $validator = new DeliveryAddressValidator('DE', self::$config);

        $address = new DeliveryAddress();
        $address->setFirstName('M');
        $address->setLastName('Muster');
        $address->setStreet('Musterstr 1');
        $address->setZip('30655');
        $address->setCity('Hannover');

        $validator->isValid($address);
        $this->assertEquals(array('firstName' => array('STRING_TOO_SHORT')), $validator->getMessages());

        $address->setFirstName('Max');
        $address->setZip('555555');
        $validator->isValid($address);
        $this->assertEquals(array('zip' => array('STRING_TOO_LONG')), $validator->getMessages());
    }
}
