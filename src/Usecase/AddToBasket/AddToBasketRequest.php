<?php

namespace Bws\Usecase\AddToBasket;

class AddToBasketRequest
{
    /**
     * @var int
     */
    private $articleId;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $basketId;

    /**
     * @param int $articleId
     * @param int $count
     * @param int $basketId
     */
    public function __construct($articleId, $count, $basketId)
    {
        $this->articleId = $articleId;
        $this->count     = $count;
        $this->basketId  = $basketId;
    }

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getBasketId()
    {
        return $this->basketId;
    }
}
