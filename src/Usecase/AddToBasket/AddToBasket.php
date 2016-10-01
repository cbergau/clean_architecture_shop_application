<?php

namespace Bws\Usecase\AddToBasket;

use Bws\Entity\Article;
use Bws\Entity\Basket;
use Bws\Repository\ArticleRepository;
use Bws\Repository\BasketPositionRepository;
use Bws\Repository\BasketRepository;
use Bws\PriceFormatter\PriceFormatter;

class AddToBasket
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var BasketRepository
     */
    private $basketRepository;

    /**
     * @var BasketPositionRepository
     */
    private $basketPositionRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        BasketPositionRepository $basketPositionRepository,
        BasketRepository $basketRepository
    ) {
        $this->articleRepository        = $articleRepository;
        $this->basketPositionRepository = $basketPositionRepository;
        $this->basketRepository         = $basketRepository;
    }

    /**
     * @param AddToBasketRequest $request
     *
     * @return AddToBasketResponse
     */
    public function execute(AddToBasketRequest $request)
    {
        if (true !== ($response = $this->isRequestValid($request))) {
            return $response;
        }

        $article = $this->articleRepository->find($request->getArticleId());

        if (!$article) {
            return new AddToBasketResponse(AddToBasketResponse::ARTICLE_NOT_FOUND, 'ARTICLE_NOT_FOUND');
        }

        return $this->addToBasket($request, $this->getBasket($request), $article);
    }

    /**
     * @param AddToBasketRequest $request
     *
     * @return bool|AddToBasketResponse True if request is valid, AddToBasketResponse if not
     */
    protected function isRequestValid(AddToBasketRequest $request)
    {
        if (null === $request->getBasketId()) {
            return new AddToBasketResponse(AddToBasketResponse::BAD_BASKET_ID, 'MISSING_BASKET_ID');
        }

        if ($this->isValidCount($request)) {
            return new AddToBasketResponse(AddToBasketResponse::ZERO_COUNT, 'ZERO_COUNT');
        }

        if (null === $request->getArticleId()) {
            return new AddToBasketResponse(AddToBasketResponse::BAD_ARTICLE_ID, 'BAD_ARTICLE_ID');
        }

        return true;
    }

    /**
     * @return \Bws\Entity\Basket
     */
    protected function createAndSaveNewBasket()
    {
        $basket = $this->basketRepository->factory();
        $this->basketRepository->save($basket);
        return $basket;
    }

    /**
     * @param AddToBasketRequest  $request
     * @param \Bws\Entity\Article $article
     * @param \Bws\Entity\Basket  $basket
     *
     * @return \Bws\Entity\BasketPosition
     */
    protected function createBasketPosition(AddToBasketRequest $request, $article, $basket)
    {
        $basketPosition = $this->basketPositionRepository->factory();
        $basketPosition->setArticle($article);
        $basketPosition->setCount($request->getCount());
        $basketPosition->setBasket($basket);
        return $basketPosition;
    }

    /**
     * @param AddToBasketRequest $request
     *
     * @return \Bws\Entity\Basket
     */
    protected function getBasket(AddToBasketRequest $request)
    {
        $basket = $this->basketRepository->find($request->getBasketId());

        if (!$basket) {
            $basket = $this->createAndSaveNewBasket();
        }

        return $basket;
    }

    /**
     * @param AddToBasketRequest $request
     * @param Basket             $basket
     * @param Article            $article
     *
     * @return AddToBasketResponse
     */
    protected function addToBasket(AddToBasketRequest $request, Basket $basket, Article $article)
    {
        $total                  = 0.0;
        $positionCount          = 0;
        $articleAlreadyInBasket = false;
        $basketPositions        = $this->basketPositionRepository->findByBasket($basket);
        $this->calculatePositions($request, $basketPositions, $positionCount, $total, $articleAlreadyInBasket);
        $this->handleNewArticleIfNeeded($request, $basket, $article, $articleAlreadyInBasket, $total, $positionCount);

        return new AddToBasketResponse(
            AddToBasketResponse::SUCCESS,
            '',
            $basket->getId(),
            PriceFormatter::format($total),
            $positionCount
        );
    }

    /**
     * @param AddToBasketRequest           $request
     * @param \Bws\Entity\BasketPosition[] $basketPositions
     * @param integer                      $positionCount
     * @param double                       $total
     * @param boolean                      $articleAlreadyInBasket
     */
    protected function calculatePositions(
        AddToBasketRequest $request,
        $basketPositions,
        &$positionCount,
        &$total,
        &$articleAlreadyInBasket
    ) {
        if (sizeof($basketPositions) > 0) {
            foreach ($basketPositions as $pos) {
                $positionCount++;

                if ($pos->getArticle()->getId() == $request->getArticleId()) {
                    $articleAlreadyInBasket = true;
                    $pos->increaseCount($request->getCount());
                    $this->basketPositionRepository->addToBasket($pos);
                }

                $total += $pos->getArticle()->getPrice() * $pos->getCount();
            }
        }
    }

    /**
     * @param AddToBasketRequest $request
     * @param Basket             $basket
     * @param Article            $article
     * @param bool               $articleAlreadyInBasket
     * @param double             $total
     * @param int                $positionCount
     */
    protected function handleNewArticleIfNeeded(
        AddToBasketRequest $request,
        Basket $basket,
        Article $article,
        $articleAlreadyInBasket,
        &$total,
        &$positionCount
    ) {
        if (!$articleAlreadyInBasket) {
            $basketPosition = $this->createBasketPosition($request, $article, $basket);
            $this->basketPositionRepository->addToBasket($basketPosition);
            $total += $basketPosition->getArticle()->getPrice() * $basketPosition->getCount();
            $positionCount++;
        }
    }

    /**
     * @param AddToBasketRequest $request
     *
     * @return bool
     */
    protected function isValidCount(AddToBasketRequest $request)
    {
        return null === $request->getCount() || 0 === $request->getCount();
    }
}
