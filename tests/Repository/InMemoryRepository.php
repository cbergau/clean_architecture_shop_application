<?php

namespace Bws\Repository;

use Bws\Entity\Entity;

class InMemoryRepository
{
    /**
     * @var Entity[]
     */
    private $entities = array();

    public function find($id)
    {
        return isset($this->entities[$id]) ? $this->entities[$id] : null;
    }

    public function findAll()
    {
        return $this->getEntities();
    }

    public function delete($id)
    {
        unset($this->entities[$id]);
    }

    /**
     * @param Entity $entity
     */
    public function doSave(Entity $entity)
    {
        if (null === $entity->getId()) {
            $entity->setId(time());
        }

        $this->entities[$entity->getId()] = $entity;
    }

    /**
     * @return \Bws\Entity\Entity[]
     */
    public function getEntities()
    {
        return $this->entities;
    }
}
