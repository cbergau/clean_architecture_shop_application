<?php

namespace Bws\Validator;

use Bws\Entity\DeliveryAddress;
use Bws\Locale\Locale;
use Bws\Translator\TranslationFileLoader;
use Bws\Translator\Translator;
use Symfony\Component\Yaml\Yaml;

class DeliveryAddressValidatorTest extends \PHPUnit_Framework_TestCase
{
    const MSG_TOO_LONG = 'This field is too long';
    const MSG_TOO_SHORT = 'This field is too short';
    
    /**
     * @var array
     */
    private static $config;

    /**
     * @var Translator
     */
    private $translator;

    public static function setUpBeforeClass()
    {
        static::$config = Yaml::parse(file_get_contents(__DIR__ . '/../../src/Validator/Rules/delivery_address.yml'));
    }

    public function getTranslator()
    {
        if (null === $this->translator) {
            $this->translator = new Translator();
            $this->translator->setTranslations(TranslationFileLoader::load(new Locale('en', 'GB')));
        }

        return $this->translator;
    }

    /**
     * @param string $region
     *
     * @return DeliveryAddressValidator
     */
    private function getValidator($region)
    {
        return new DeliveryAddressValidator($region, static::$config, $this->getTranslator());
    }

    public function invalidAddressesProvider()
    {
        return array(
            array('DE', 'Max', 'Muster', 'Musterstr 1', '123456', 'Hannover', array('zip' => array(static::MSG_TOO_LONG))),
            array('DE', 'Max', 'Muster', 'Musterstr 2', '1', 'Hannover', array('zip' => array(static::MSG_TOO_SHORT))),
            array(
                'DE',
                'M',
                'Muster',
                'Musterstr 2',
                '1',
                'Hannover',
                array(
                    'firstName' => array(static::MSG_TOO_SHORT),
                    'zip' => array(static::MSG_TOO_SHORT)
                ),
            ),
        );
    }

    /**
     * @dataProvider invalidAddressesProvider
     */
    public function testInvalidAddresses($region, $firstName, $lastName, $street, $zip, $city, $messages)
    {
        $address = new DeliveryAddress();
        $address->setFirstName($firstName);
        $address->setLastName($lastName);
        $address->setStreet($street);
        $address->setZip($zip);
        $address->setCity($city);

        $validator = $this->getValidator($region);

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
        $address = new DeliveryAddress();
        $address->setFirstName($firstName);
        $address->setLastName($lastName);
        $address->setStreet($street);
        $address->setZip($zip);
        $address->setCity($city);

        $validator = $this->getValidator($region);

        $this->assertTrue($validator->isValid($address));
        $this->assertEquals(array(), $validator->getMessages());
    }

    public function testValidatingTwoTimesShouldResetErrorMessages()
    {
        $address = new DeliveryAddress();
        $address->setFirstName('M');
        $address->setLastName('Muster');
        $address->setStreet('Musterstr 1');
        $address->setZip('30655');
        $address->setCity('Hannover');

        $validator = $this->getValidator('DE');

        $validator->isValid($address);
        $validator->isValid($address);

        $this->assertEquals(array('firstName' => array(static::MSG_TOO_SHORT)), $validator->getMessages());
    }

    public function testValidatingTwoTimesWithDifferentErrorsShouldResetErrorMessages()
    {
        $address = new DeliveryAddress();
        $address->setFirstName('M');
        $address->setLastName('Muster');
        $address->setStreet('Musterstr 1');
        $address->setZip('30655');
        $address->setCity('Hannover');

        $validator = $this->getValidator('DE');

        $validator->isValid($address);
        $this->assertEquals(array('firstName' => array(static::MSG_TOO_SHORT)), $validator->getMessages());

        $address->setFirstName('Max');
        $address->setZip('555555');
        $validator->isValid($address);
        $this->assertEquals(array('zip' => array(static::MSG_TOO_LONG)), $validator->getMessages());
    }
}
