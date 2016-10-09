<?php

namespace Bws\Translator;

use Bws\Locale\Locale;
use Symfony\Component\Yaml\Yaml;

class TranslationFileLoader
{
    /**
     * @param Locale $locale
     *
     * @return string[]
     */
    public static function load(Locale $locale)
    {
        $filePath = __DIR__ . '/../../translations/translations.' . $locale->__toString() . '.yml';
        $parse = Yaml::parse(file_get_contents($filePath));
        return $parse['translations'][$locale->__toString()] ?: array();
    }
}
