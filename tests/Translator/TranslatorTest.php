<?php

namespace Bws\Translator;

class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    public function testGivenTranslationNotFound_ReturnsKeyBack()
    {
        $translator = new Translator();
        $translator->setTranslations(array('SOME_KEY' => 'The translation'));

        $this->assertSame('SOME_KEY_THAT_DOES_NOT_EXIST', $translator->translate('SOME_KEY_THAT_DOES_NOT_EXIST'));
    }

    public function testGivenTranslationKeyIsEmpty_ReturnsEmptyString()
    {
        $translator = new Translator();
        $translator->setTranslations(array('SOME_KEY' => 'The translation'));

        $this->assertSame('', $translator->translate(''));
        $this->assertSame('', $translator->translate(null));
    }

    public function testGivenTranslationKeyIsSet_ReturnsTranslatedString()
    {
        $translator = new Translator();
        $translator->setTranslations(array('SOME_KEY' => 'The translation'));

        $this->assertSame('The translation', $translator->translate('SOME_KEY'));
    }
}
