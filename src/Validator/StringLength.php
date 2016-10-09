<?php

namespace Bws\Validator;

class StringLength implements ValidatorInterface
{
    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * @var string[]
     */
    private $messages = array();

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->min = $options['min'];
        $this->max = $options['max'];
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $result = true;

        if (strlen($value) < $this->min) {
            $this->messages[] = 'ERROR_MESSAGE_TOO_SHORT';
            $result           = false;
        }

        if (strlen($value) > $this->max) {
            $this->messages[] = 'ERROR_MESSAGE_TOO_LONG';
            $result           = false;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
