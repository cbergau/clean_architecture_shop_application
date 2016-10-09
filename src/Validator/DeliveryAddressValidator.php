<?php

namespace Bws\Validator;

use Bws\Entity\DeliveryAddress;
use Bws\Translator\Translator;

class DeliveryAddressValidator
{
    private $region;
    private $config;

    /**
     * @var string[]
     */
    private $messages = array();

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @param string $region
     * @param array $config
     * @param Translator $translator
     */
    public function __construct($region, $config, Translator $translator)
    {
        $this->region = $region;
        $this->config = $config;
        $this->translator = $translator;
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     *
     * @return bool
     */
    public function isValid(DeliveryAddress $deliveryAddress)
    {
        $this->messages = array();
        return $this->doValidate($deliveryAddress, $this->getValidators());
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     * @param                 ValidatorInterface[] $validators
     *
     * @return bool
     */
    protected function doValidate(DeliveryAddress $deliveryAddress, $validators)
    {
        $isValid = true;

        foreach ($validators as $property => $validatorsForProperty) {
            $isValid = $this->validateProperty($deliveryAddress, $validatorsForProperty, $property);
        }

        return $isValid;
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     * @param                 $validatorsForProperty
     * @param                 $property
     *
     * @return bool
     */
    protected function validateProperty(DeliveryAddress $deliveryAddress, $validatorsForProperty, $property)
    {
        $isEverythingValid = true;

        /** @var ValidatorInterface $validator */
        foreach ($validatorsForProperty as $validator) {
            $getterMethod = 'get' . ucfirst($property);
            $value = $deliveryAddress->$getterMethod();
            $isValueValid = $validator->isValid($value);
            $isEverythingValid = $isEverythingValid && $isValueValid;

            if (!$isValueValid) {
                foreach ($validator->getMessages() as $message) {
                    $this->messages[$property][] = $this->translator->translate($message);
                }
            }
        }

        return $isEverythingValid;
    }

    /**
     * @return ValidatorInterface[]
     */
    protected function getValidators()
    {
        $validatorInstances = array();

        foreach ($this->config as $properties) {
            $validatorInstances = $this->getPropertiesValidators($properties, $validatorInstances);
        }

        return $validatorInstances;
    }

    /**
     * @param $validators
     * @param $validatorInstances
     * @param $property
     *
     * @return mixed
     */
    protected function getSingleValidator($validators, $validatorInstances, $property)
    {
        foreach ($validators as $validatorName => $validatorConfig) {
            $validatorInstances = $this->getValidator($validatorInstances, $property, $validatorConfig, $validatorName);
        }

        return $validatorInstances;
    }

    /**
     * @param $properties
     * @param $validatorInstances
     *
     * @return mixed
     */
    protected function getPropertiesValidators($properties, $validatorInstances)
    {
        foreach ($properties as $property => $validators) {
            $validatorInstances = $this->getSingleValidator(
                $validators['validators'],
                $validatorInstances,
                $property
            );
        }
        return $validatorInstances;
    }

    /**
     * @param $validatorInstances
     * @param $property
     * @param $validatorConfig
     * @param $validatorName
     *
     * @return mixed
     */
    protected function getValidator($validatorInstances, $property, $validatorConfig, $validatorName)
    {
        $mergedOptions = array();
        $defaultRegionConfiguration = array();

        foreach ($validatorConfig['options'] as $x => $regionalConfig) {
            foreach ($regionalConfig as $regionName => $optionsForRegion) {
                if ($regionName == 'default') {
                    $defaultRegionConfiguration = $optionsForRegion;
                } else {
                    if (strtolower($regionName) == strtolower($this->region)) {
                        $mergedOptions = array_merge($defaultRegionConfiguration, $optionsForRegion);
                    }
                }
            }
        }

        $className = 'Bws\Validator\\' . $validatorName;
        $finalOptions = $mergedOptions ? $mergedOptions : $defaultRegionConfiguration;
        $validatorInstances[$property][] = new $className($finalOptions);
        return $validatorInstances;
    }
}
