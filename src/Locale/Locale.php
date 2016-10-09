<?php

namespace Bws\Locale;

use InvalidArgumentException;

/**
 * @todo ISO
 */
class Locale
{
    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $region;

    /**
     * @param string $language
     * @param string $region
     */
    public function __construct($language, $region)
    {
        if (empty($language)) {
            throw new InvalidArgumentException('Invalid language');
        }

        if (empty($region)) {
            throw new InvalidArgumentException('Invalid region');
        }

        $this->language = $language;
        $this->region = $region;
    }

    /**
     * @param string $locale
     * @return static
     */
    public static function fromString($locale)
    {
        if (!preg_match('/^[a-z]{2,2}_[A-Z]{2,2}$/', $locale)) {
            throw new InvalidArgumentException('Format must be %s_%s with language and region');
        }

        $parts = explode('_', $locale);
        return new static($parts[0], $parts[1]);
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    public function __toString()
    {
        return $this->language . '_' . $this->region;
    }
}
