<?php

namespace Bws\Repository;

use Bws\Entity\PaymentMethod;

class PaymentMethodRepositoryMock extends InMemoryRepository implements PaymentMethodRepository
{
    /**
     * @return PaymentMethod[]
     */
    public function findAll()
    {
        return parent::findAll();
    }

    /**
     * @param int $id
     *
     * @return PaymentMethod
     */
    public function find($id)
    {
        return parent::find($id);
    }
}
