<?php

namespace Bws\Entity;

use Bws\PriceFormatter\PriceFormatter;
use Bws\Repository\BasketPositionRepositoryMock;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOrderValueWithEmptyBasket()
    {
        $order = new Order();

        $basket = new Basket();
        $order->setBasket($basket);

        $position = new BasketPositionStub();
        $position->setBasket($basket);

        $basketPositionRepository = new BasketPositionRepositoryMock();
        $basketPositionRepository->addToBasket($position);

        $order->setBasket($basket);

        $this->assertSame(0.00, $order->getValue());
    }

    public function testGetOrderValueWithoutAnyBasket()
    {
        $order = new Order();
        $this->assertSame(0.00, $order->getValue());
    }

    public function testGetOrderValueWithoutAnyPositionsInBasket()
    {
        $order = new Order();
        $basket = new Basket();
        $order->setBasket($basket);
        $this->assertSame(0.00, $order->getValue());
    }

    public function testGetOrderValueWithSinglePosition()
    {
        $order = new Order();

        $basket = new Basket();
        $order->setBasket($basket);

        $position = new BasketPositionStub();
        $position->setBasket($basket);
        $position->setArticle(new ArticleStub());
        $position->setCount(1);

        $basket->setBasketPositions(array($position));

        $basketPositionRepository = new BasketPositionRepositoryMock();
        $basketPositionRepository->addToBasket($position);

        $order->setBasket($basket);

        $this->assertSame(PriceFormatter::format(ArticleStub::PRICE), $order->getValue());
    }

    public function testGetOrderValueWithMultiplePositions()
    {
        $order = new Order();

        $basket = new Basket();
        $order->setBasket($basket);

        $position = new BasketPositionStub();
        $position->setBasket($basket);
        $position->setArticle(new ArticleStub());
        $position->setCount(1);

        $basket->setBasketPositions(array($position, $position));

        $basketPositionRepository = new BasketPositionRepositoryMock();
        $basketPositionRepository->addToBasket($position);

        $order->setBasket($basket);

        $this->assertSame(PriceFormatter::format(ArticleStub::PRICE * 2), $order->getValue());
    }


}
