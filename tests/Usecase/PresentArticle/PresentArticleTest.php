<?php

namespace Bws\Usecase\PresentArticle;

use Bws\Entity\ArticleStub;
use Bws\Repository\ArticleRepositoryMock;
use PHPUnit_Framework_TestCase;

class PresentArticleTest extends PHPUnit_Framework_TestCase
{
    public function testArticleNotFoundReturnsError()
    {
        $repository = new ArticleRepositoryMock();
        $interactor = new PresentArticle($repository);

        $result = $interactor->execute(0);

        $this->assertEquals(PresentArticleResponse::ARTICLE_NOT_FOUND, $result->getCode());
    }

    public function testArticleFound()
    {
        $repository = new ArticleRepositoryMock();
        $repository->doSave(new ArticleStub());

        $interactor = new PresentArticle($repository);

        $result = $interactor->execute(ArticleStub::ID);

        $this->assertEquals(PresentArticleResponse::SUCCESS, $result->getCode());
        $this->assertEquals(new ArticleStub(), $result->getArticle());
    }
}
