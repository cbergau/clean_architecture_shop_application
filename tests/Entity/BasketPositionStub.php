<?php

namespace Bws\Entity;

class BasketPositionStub extends BasketPosition
{
    const ID = 5;

    public function __construct()
    {
        $this->setId(BasketPositionStub::ID);
        $this->setArticle(new ArticleStub());
        $this->setCount(1);
    }
}
