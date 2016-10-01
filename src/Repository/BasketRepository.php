<?php

namespace Bws\Repository;

use Bws\Entity\Basket;

interface BasketRepository
{
    /**
     * @param integer $id
     *
     * @return Basket
     */
    public function find($id);

    /**
     * @param Basket $basket
     * @return void
     */
    public function save(Basket $basket);

    /**
     * @return Basket
     */
    public function factory();
}
