<?php

namespace Bws\Entity;

class ArticleStub extends Article
{
    const ID = 12;
    const TITLE = 'some title';
    const PRICE = 9.99;
    const IMAGE_PATH = '/path/to/image.png';
    const EAN = '978-013235088';
    const DESCRIPTION = 'some description';

    public function __construct()
    {
        $this->setId(self::ID);
        $this->setTitle(self::TITLE);
        $this->setEan(self::EAN);
        $this->setDescription(self::DESCRIPTION);
        $this->setPrice(self::PRICE);
        $this->setImagePath(self::IMAGE_PATH);
    }
}
