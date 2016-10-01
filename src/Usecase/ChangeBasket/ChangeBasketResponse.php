<?php

namespace Bws\Usecase\ChangeBasket;

class ChangeBasketResponse
{
    const SUCCESS                  = 1;
    const BASKET_NOT_FOUND         = -1;
    const BAD_BASKET_ID            = -2;
    const BAD_COUNT                = -3;
    const BAD_ARTICLE_ID           = -4;
    const ARTICLE_IS_NOT_IN_BASKET = -5;
    const BASKET_IS_EMPTY          = -6;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @param integer $code
     * @param string  $message
     */
    public function __construct($code, $message = '')
    {
        $this->code    = $code;
        $this->message = $message;
    }

    /**
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
