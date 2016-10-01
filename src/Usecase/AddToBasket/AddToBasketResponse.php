<?php

namespace Bws\Usecase\AddToBasket;

class AddToBasketResponse
{
    const SUCCESS           = 1;
    const ARTICLE_NOT_FOUND = -1;
    const BAD_BASKET_ID     = -2;
    const ZERO_COUNT        = -3;
    const BAD_ARTICLE_ID    = -4;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var integer
     */
    private $basketId;

    /**
     * @var float
     */
    private $total;

    /**
     * @var integer
     */
    private $posCount;

    /**
     * @param integer $code
     * @param string  $message
     * @param integer $basketId
     * @param float   $total
     * @param integer $posCount
     */
    public function __construct($code, $message, $basketId = 0, $total = 0.0, $posCount = 0)
    {
        $this->code     = $code;
        $this->message  = $message;
        $this->basketId = $basketId;
        $this->total    = $total;
        $this->posCount = $posCount;
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

    /**
     * @return integer
     */
    public function getBasketId()
    {
        return $this->basketId;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return integer
     */
    public function getPosCount()
    {
        return $this->posCount;
    }
}
