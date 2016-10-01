<?php

namespace Bws\Entity;

use ArrayAccess;

class Basket extends Entity
{
    /**
     * @var ArrayAccess
     */
    protected $basketPositions;

    /**
     * @param ArrayAccess $basketPositions
     */
    public function setBasketPositions($basketPositions)
    {
        $this->basketPositions = $basketPositions;
    }

    /**
     * @return ArrayAccess
     */
    public function getPositions()
    {
        return $this->basketPositions;
    }
}
