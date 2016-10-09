<?php

namespace Bws\Locale;

class LocaleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $locale = new Locale('en', 'GB');
        $this->assertSame('en', $locale->getLanguage());
        $this->assertSame('GB', $locale->getRegion());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid language
     */
    public function testInvalidLanguageThrowsException()
    {
        new Locale('', 'GB');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid region
     */
    public function testInvalidCountryThrowsException()
    {
        new Locale('en', '');
    }

    public function testToString()
    {
        $locale = new Locale('en', 'GB');
        $this->assertSame('en_GB', $locale->__toString());
    }

    public function testFromString()
    {
        $locale = Locale::fromString('en_GB');
        $this->assertSame('en', $locale->getLanguage());
        $this->assertSame('GB', $locale->getRegion());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Format must be %s_%s with language and region
     */
    public function testFromStringWithInvalidInput()
    {
        Locale::fromString('enGB');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Format must be %s_%s with language and region
     */
    public function testFromStringWithEmptyInput()
    {
        Locale::fromString('');
    }
}
