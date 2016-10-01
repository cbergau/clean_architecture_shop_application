<?php

namespace Bws\Entity;

class ArticleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Article
     */
    private $article;

    public function setUp()
    {
        $this->article = new Article();
    }

    public function testGetSetEan()
    {
        $this->article->setEan('913-123456');
        $this->assertEquals('913-123456', $this->article->getEan());
    }

    public function testGetSetDescription()
    {
        $this->article->setDescription('some article description');
        $this->assertEquals('some article description', $this->article->getDescription());
    }
}
