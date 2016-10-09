<?php

namespace Bws\Validator;

use Bws\Locale\Locale;
use Bws\Translator\TranslationFileLoader;
use Bws\Translator\Translator;
use Symfony\Component\Yaml\Yaml;

class DeliveryAddressValidatorFactory
{
    /**
     * @param string $region
     *
     * @todo Refactor to TranslationLoaderInterface
     *
     * @return DeliveryAddressValidator
     */
    public static function getDeliveryAddressValidator($region)
    {
        $translator = new Translator();
        $translator->setTranslations(TranslationFileLoader::load(Locale::fromString($region)));

        $validator = new DeliveryAddressValidator(
            $region,
            Yaml::parse(file_get_contents(__DIR__ . '/Rules/delivery_address.yml')),
            $translator
        );

        return $validator;
    }
}
