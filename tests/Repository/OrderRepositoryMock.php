<?php

namespace Bws\Repository;

use Bws\Entity\Order;

class OrderRepositoryMock extends InMemoryRepository implements OrderRepository
{
    private $lastInserted;

    /**
     * @param Order $order
     */
    public function save(Order $order)
    {
        parent::doSave($order);
        $this->lastInserted = $order;
    }

    /**
     * @return Order
     */
    public function factory()
    {
        return new Order();
    }

    /**
     * @return Order
     */
    public function findLastInserted()
    {
        return $this->lastInserted;
    }


    /**
     * @param int $userId
     *
     * @return Order[]
     */
    public function findByUserId($userId)
    {
        $orders = array();

        /** @var Order $order */
        foreach ($this->getEntities() as $order) {
            if ($order->getCustomer()->getId() == $userId) {
                $orders[] = $order;
            }
        }

        return $orders;
    }
}
