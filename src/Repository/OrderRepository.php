<?php
/**
 * BWS WebShop
 *
 * @author Christian Bergau <cbergau86@gmail.com>
 */

namespace Bws\Repository;

use Bws\Entity\Order;

interface OrderRepository
{
    /**
     * @param Order $order
     * @return void
     */
    public function save(Order $order);

    /**
     * @return Order
     */
    public function factory();

    /**
     * @param int $userId
     *
     * @return Order[]
     */
    public function findByUserId($userId);
}
