<?php

namespace Bws\Translator;

use Bws\Locale\Locale;

class TranslatorFileLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $translations = TranslationFileLoader::load(new Locale('en', 'GB'));

        $this->assertArrayHasKey('ERROR_MESSAGE_TOO_SHORT', $translations);
    }
}
