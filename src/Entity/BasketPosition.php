<?php

namespace Bws\Entity;

class BasketPosition extends Entity
{
    /**
     * @var integer
     */
    protected $count;

    /**
     * @var Basket
     */
    protected $basket;

    /**
     * @var Article
     */
    protected $article;


    /**
     * Set count
     *
     * @param integer $count
     *
     * @return BasketPosition
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $by
     *
     * @return $this
     */
    public function increaseCount($by)
    {
        $this->setCount($this->getCount() + (int) $by);

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set basket
     *
     * @param Basket $basket
     *
     * @return BasketPosition
     */
    public function setBasket(Basket $basket = null)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return Basket
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * Set article
     *
     * @param Article $article
     *
     * @return BasketPosition
     */
    public function setArticle(Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
