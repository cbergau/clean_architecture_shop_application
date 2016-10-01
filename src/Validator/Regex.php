<?php

namespace Bws\Validator;

class Regex implements Validator
{
    private $pattern;
    private $messages = array();

    public function __construct(array $options)
    {
        $this->pattern = $options['pattern'];
    }

    public function isValid($value)
    {
        $valid = true;

        if (preg_match_all($this->pattern, $value) != 1) {
            $valid = false;
            $this->messages[] = 'NOT_MATCH';
        }

        return $valid;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
