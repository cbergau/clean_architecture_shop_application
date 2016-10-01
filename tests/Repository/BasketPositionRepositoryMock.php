<?php

namespace Bws\Repository;

use Bws\Entity\Basket;
use Bws\Entity\BasketPosition;

class BasketPositionRepositoryMock extends InMemoryRepository implements BasketPositionRepository
{
    /**
     * @var int
     */
    private $findById;

    /**
     * @var int
     */
    private $addToBasketCalls = 0;

    /**
     * @var int
     */
    private $removeCalls = 0;

    /**
     * @param int $id
     *
     * @return BasketPosition
     */
    public function find($id)
    {
        $this->findById = $id;
        return parent::find($id);
    }

    /**
     * @return Basket
     */
    public function factory()
    {
        return new BasketPosition();
    }

    /**
     * @return mixed
     */
    public function getFindByIdArgument()
    {
        return $this->findById;
    }

    /**
     * @param Basket $basket
     *
     * @return BasketPosition[]
     */
    public function findByBasket(Basket $basket)
    {
        $positions = array();

        /** @var BasketPosition $position */
        foreach ($this->getEntities() as $position) {
            if ($position->getBasket()->getId() == $basket->getId()) {
                $positions[] = $position;
            }
        }

        return $positions;
    }

    /**
     * @param BasketPosition $basketPosition
     */
    public function addToBasket(BasketPosition $basketPosition)
    {
        $this->addToBasketCalls++;
        parent::doSave($basketPosition);
    }

    /**
     * @param BasketPosition $position
     *
     * @return mixed
     */
    public function removeFromBasket(BasketPosition $position)
    {
        $this->removeCalls++;
        parent::delete($position->getId());
    }

    /**
     * @return BasketPosition[]
     */
    public function findAll()
    {
        return $this->getEntities();
    }

    /**
     * @return int
     */
    public function getAddToBasketCalls()
    {
        return $this->addToBasketCalls;
    }

    /**
     * @return int
     */
    public function getRemoveCalls()
    {
        return $this->removeCalls;
    }
}
