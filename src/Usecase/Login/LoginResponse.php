<?php

namespace Bws\Usecase\Login;

class LoginResponse
{
    const SUCCESS                 = 1;
    const FAILURE                 = 0;
    const WRONG_PASSWORD_BIRTHDAY = -1;
    const WRONG_PASSWORD          = -2;
    const WRONG_EMAIL_ADDRESS     = -3;

    /**
     * @var int
     */
    public $code;

    /**
     * @var array
     */
    public $messages = array();

    /**
     * @var int
     */
    public $customerId;

    /**
     * @var string
     */
    public $display;
}
