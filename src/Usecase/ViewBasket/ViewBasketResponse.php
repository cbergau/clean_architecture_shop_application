<?php

namespace Bws\Usecase\ViewBasket;

class ViewBasketResponse
{
    const SUCCESS          = 1;
    const BAD_BASKET_ID    = -1;
    const BASKET_NOT_FOUND = -2;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $positions;

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
     * @param array   $positions
     * @param float   $total
     * @param integer $positionCount
     */
    public function __construct($code, $message, $positions = array(), $total = 0.0, $positionCount = 0)
    {
        $this->code      = $code;
        $this->message   = $message;
        $this->positions = $positions;
        $this->total     = $total;
        $this->posCount  = $positionCount;
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
     * @return array
     */
    public function getPositions()
    {
        return $this->positions;
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
    public function getPositionCount()
    {
        return $this->posCount;
    }
}
