<?php

namespace Bws\Usecase\ShowOrders;

class PresentableOrder
{
    /**
     * @var int
     */
    public $number;

    /**
     * @var \DateTime
     */
    public $date;

    /**
     * @var string
     */
    public $totalValue;

    public $positions = array();

    /**
     * @var array
     */
    public $invoiceAddress;

    /**
     * @var array
     */
    public $deliveryAddress;
}
