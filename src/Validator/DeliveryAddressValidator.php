<?php

namespace Bws\Validator;

use Bws\Entity\DeliveryAddress;

class DeliveryAddressValidator
{
    private $region;
    private $config;
    private $messages = array();

    /**
     * @param string $region
     * @param array  $config
     */
    public function __construct($region, $config)
    {
        $this->region = $region;
        $this->config = $config;
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     *
     * @return bool
     */
    public function isValid(DeliveryAddress $deliveryAddress)
    {
        $valid = true;
        $this->messages = array();
        return $this->doValidate($deliveryAddress, $this->getValidators(), $valid);
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
     * @param                 Validator[] $validators
     * @param                 boolean $isValid
     *
     * @return bool
     */
    protected function doValidate(DeliveryAddress $deliveryAddress, $validators, $isValid)
    {
        foreach ($validators as $property => $validatorsForProperty) {
            $isValid = $this->validateProperty($deliveryAddress, $isValid, $validatorsForProperty, $property);
        }

        return $isValid;
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     * @param                 $valid
     * @param                 $validatorsForProperty
     * @param                 $property
     *
     * @return bool
     */
    protected function validateProperty(DeliveryAddress $deliveryAddress, $valid, $validatorsForProperty, $property)
    {
        /** @var Validator $validator */
        foreach ($validatorsForProperty as $validator) {
            $getter                  = 'get' . ucfirst($property);
            $value                   = $deliveryAddress->$getter();
            $currentValidatorIsValid = $validator->isValid($value);
            $valid                   = $valid && $currentValidatorIsValid;

            if (!$currentValidatorIsValid) {
                $this->messages[$property] = $validator->getMessages();
            }
        }

        return $valid;
    }

    /**
     * @return Validator[]
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
        $mergedOptions              = array();
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

        $className                       = 'Bws\Validator\\' . $validatorName;
        $finalOptions                    = $mergedOptions ? $mergedOptions : $defaultRegionConfiguration;
        $validatorInstances[$property][] = new $className($finalOptions);
        return $validatorInstances;
    }
}
