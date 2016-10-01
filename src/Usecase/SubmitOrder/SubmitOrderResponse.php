<?php

namespace Bws\Usecase\SubmitOrder;

class SubmitOrderResponse
{
    const SUCCESS                    = 1;
    const CUSTOMER_NOT_FOUND         = -1;
    const DELIVERY_ADDRESS_NOT_FOUND = -2;
    const BASKET_NOT_FOUND           = -3;
    const PAYMENT_METHOD_NOT_FOUND   = -4;
    const PAYMENT_METHOD_ID_INVALID  = -5;
    const LOGISTIC_PARTNER_NOT_FOUND = -6;

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
    private $orderId;

    /**
     * @param integer $code
     * @param string  $message
     * @param integer $orderId
     */
    public function __construct($code, $message = '', $orderId = 0)
    {
        $this->code    = $code;
        $this->message = $message;
        $this->orderId = $orderId;
    }

    /**
     * @return int
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
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
}
