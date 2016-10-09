<?php

namespace Bws\Translator;

class Translator
{
    /**
     * @var string[]
     */
    private $translations;

    /**
     * @param array $translations associative array with key => translation
     */
    public function setTranslations(array $translations)
    {
        $this->translations = $translations;
    }

    public function translate($key)
    {
        if (empty($key)) {
            return '';
        }

        if (!isset($this->translations[$key])) {
            return $key;
        }

        return $this->translations[$key];
    }
}
