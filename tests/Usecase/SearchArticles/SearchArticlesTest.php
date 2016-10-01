<?php

namespace Bws\Usecase\SearchArticles;

use Bws\Entity\ArticleStub;
use Bws\Repository\ArticleRepositoryMock;

class SearchArticlesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArticleRepositoryMock
     */
    private $articleRepository;

    /**
     * @var SearchArticles
     */
    private $interactor;

    public function setUp()
    {
        $this->articleRepository = new ArticleRepositoryMock();
        $this->interactor        = new SearchArticles($this->articleRepository);
    }

    public function testNoArticlesFound()
    {
        $response = $this->interactor->execute(new SearchArticlesRequest('An Article which does not exist'));
        $this->assertEquals(array(), $response->getArticles());
        $this->assertEquals(1, $this->articleRepository->getSearchCallCount());
    }

    public function testArticlesFound()
    {
        $this->articleRepository->doSave(new ArticleStub());

        $response = $this->interactor->execute(new SearchArticlesRequest(ArticleStub::TITLE));

        $this->assertEquals(
            array(
                array(
                    'id'          => ArticleStub::ID,
                    'ean'         => ArticleStub::EAN,
                    'title'       => ArticleStub::TITLE,
                    'description' => ArticleStub::DESCRIPTION,
                    'price'       => ArticleStub::PRICE,
                    'imagePath'   => ArticleStub::IMAGE_PATH,
                ),
            ),
            $response->getArticles()
        );
        $this->assertEquals(1, $this->articleRepository->getSearchCallCount());
    }
}
