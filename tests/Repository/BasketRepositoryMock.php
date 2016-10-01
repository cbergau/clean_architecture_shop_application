<?php

namespace Bws\Repository;

use Bws\Entity\Basket;

class BasketRepositoryMock extends InMemoryRepository implements BasketRepository
{
    /**
     * @var int
     */
    private $findById;

    /**
     * @param int $id
     *
     * @return Basket
     */
    public function find($id)
    {
        $this->findById = $id;
        return parent::find($id);
    }

    /**
     * @param Basket $basket
     */
    public function save(Basket $basket)
    {
        parent::doSave($basket);
    }

    /**
     * @return Basket
     */
    public function factory()
    {
        return new Basket();
    }

    /**
     * @return int
     */
    public function getFindByIdArgument()
    {
        return $this->findById;
    }
}
