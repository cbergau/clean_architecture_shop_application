<?php

namespace Bws\Usecase\ChangeBasket;

class ChangeBasketRequest
{
    /**
     * @var integer
     */
    public $basketId;

    /**
     * @var integer
     */
    public $articleId;

    /**
     * @var integer
     */
    public $count;

    /**
     * @param integer $articleId
     * @param integer $basketId
     * @param integer $count
     */
    public function __construct($articleId, $basketId, $count)
    {
        $this->articleId = $articleId;
        $this->basketId  = $basketId;
        $this->count     = $count;
    }

    /**
     * @return integer
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @return integer
     */
    public function getBasketId()
    {
        return $this->basketId;
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }
}
