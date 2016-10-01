<?php

namespace Bws\Repository;

use Bws\Entity\Basket;
use Bws\Entity\BasketPosition;

interface BasketPositionRepository
{
    /**
     * @param Basket $basket
     *
     * @return BasketPosition[]
     */
    public function findByBasket(Basket $basket);

    /**
     * @param BasketPosition $basketPosition
     * @return void
     */
    public function addToBasket(BasketPosition $basketPosition);

    /**
     * @return BasketPosition
     */
    public function factory();

    /**
     * @param BasketPosition $position
     *
     * @return mixed
     */
    public function removeFromBasket(BasketPosition $position);
}
