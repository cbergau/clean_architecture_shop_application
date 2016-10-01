<?php

namespace Bws\Usecase\ChangeBasket;

use Bws\Entity\ArticleStub;
use Bws\Entity\BasketPositionStub;
use Bws\Entity\BasketStub;
use Bws\Entity\EmptyBasketStub;
use Bws\Repository\BasketPositionRepositoryMock;
use Bws\Repository\BasketRepositoryMock;

class ChangeBasketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BasketPositionRepositoryMock
     */
    private $basketPositionRepository;

    /**
     * @var BasketRepositoryMock
     */
    private $basketRepository;

    /**
     * @var ChangeBasket
     */
    private $interactor;

    public function setUp()
    {
        $this->basketPositionRepository = new BasketPositionRepositoryMock();
        $this->basketRepository         = new BasketRepositoryMock();
        $this->interactor               = new ChangeBasket($this->basketPositionRepository, $this->basketRepository);
    }

    public function testBadBasketId()
    {
        $response = $this->interactor->execute(new ChangeBasketRequest(ArticleStub::ID, null, 2));
        $this->assertEquals(ChangeBasketResponse::BAD_BASKET_ID, $response->getCode());
    }

    public function testBadCount()
    {
        $response = $this->interactor->execute(new ChangeBasketRequest(ArticleStub::ID, 12356, null));
        $this->assertEquals(ChangeBasketResponse::BAD_COUNT, $response->getCode());
    }

    public function testBadArticleId()
    {
        $response = $this->interactor->execute(new ChangeBasketRequest(null, 12356, 2));
        $this->assertEquals(ChangeBasketResponse::BAD_ARTICLE_ID, $response->getCode());
    }

    public function testBasketNotFound()
    {
        $response = $this->interactor->execute(new ChangeBasketRequest(ArticleStub::ID, 12356, 2));
        $this->assertEquals(ChangeBasketResponse::BASKET_NOT_FOUND, $response->getCode());
    }

    public function testBasketIsEmpty()
    {
        $this->basketRepository->doSave(new EmptyBasketStub());
        $response = $this->interactor->execute(new ChangeBasketRequest(ArticleStub::ID, EmptyBasketStub::ID, 2));
        $this->assertEquals(ChangeBasketResponse::BASKET_IS_EMPTY, $response->getCode());
    }

    public function testArticleIsNotInBasket()
    {
        $basket = new BasketStub();
        $position = new BasketPositionStub();
        $position->setBasket($basket);

        $this->basketRepository->save($basket);
        $this->basketPositionRepository->addToBasket($position);

        $request  = new ChangeBasketRequest(9999, BasketStub::ID, 2);

        $response = $this->interactor->execute($request);

        $this->assertEquals(ChangeBasketResponse::ARTICLE_IS_NOT_IN_BASKET, $response->getCode());
    }

    public function testBasketPositionRemovedIfCountIsZero()
    {
        $basket = new BasketStub();
        $position = new BasketPositionStub();
        $position->setBasket($basket);

        $this->basketRepository->save($basket);
        $this->basketPositionRepository->addToBasket($position);

        $request  = new ChangeBasketRequest(ArticleStub::ID, BasketStub::ID, 0);

        $response = $this->interactor->execute($request);

        $this->assertEquals(ChangeBasketResponse::SUCCESS, $response->getCode());
        $this->assertEquals('', $response->getMessage());
        $this->assertEquals(0, sizeof($this->basketPositionRepository->findAll()));
    }

    public function testBasketPositionCountIncreased()
    {
        $basket = new BasketStub();
        $position = new BasketPositionStub();
        $position->setBasket($basket);

        $this->basketRepository->save($basket);
        $this->basketPositionRepository->addToBasket($position);

        $request  = new ChangeBasketRequest(ArticleStub::ID, BasketStub::ID, 2);
        $response = $this->interactor->execute($request);
        $this->assertEquals(ChangeBasketResponse::SUCCESS, $response->getCode());
        $this->assertEquals(2, $this->basketPositionRepository->find(BasketPositionStub::ID)->getCount());

        $request  = new ChangeBasketRequest(ArticleStub::ID, BasketStub::ID, 3);
        $response = $this->interactor->execute($request);
        $this->assertEquals(ChangeBasketResponse::SUCCESS, $response->getCode());
        $this->assertEquals(3, $this->basketPositionRepository->find(BasketPositionStub::ID)->getCount());
    }
}
