<?php

namespace Bws\Usecase\ViewBasket;

use ArrayAccess;
use Bws\Entity\BasketPosition;
use Bws\Repository\BasketRepository;
use Bws\PriceFormatter\PriceFormatter;

class ViewBasket
{
    /**
     * @var BasketRepository
     */
    private $basketRepository;

    public function __construct(BasketRepository $basketRepository)
    {
        $this->basketRepository   = $basketRepository;
    }

    /**
     * @param int $basketId
     *
     * @return ViewBasketResponse
     */
    public function execute($basketId)
    {
        if (null === $basketId) {
            return new ViewBasketResponse(
                ViewBasketResponse::BAD_BASKET_ID,
                'BAD_BASKET_ID',
                array(),
                PriceFormatter::format(0.00)
            );
        }

        $basket = $this->basketRepository->find($basketId);

        if (!$basket) {
            return new ViewBasketResponse(ViewBasketResponse::BASKET_NOT_FOUND, 'BASKET_NOT_FOUND');
        }

        $positions = $basket->getPositions();

        if (sizeof($positions) == 0) {
            return new ViewBasketResponse(ViewBasketResponse::SUCCESS, '');
        }

        return $this->buildResponseFromPositions($positions);
    }

    /**
     * @param \ArrayAccess $positions
     *
     * @return ViewBasketResponse
     */
    protected function buildResponseFromPositions(ArrayAccess $positions)
    {
        $positionsDto = array();
        $total        = 0.0;

        $this->buildPositionsDtoAndCalculatePrices($positions, $positionsDto, $total);

        return new ViewBasketResponse(
            ViewBasketResponse::SUCCESS,
            '',
            $positionsDto,
            PriceFormatter::format($total),
            sizeof($positions)
        );
    }

    /**
     * @param ArrayAccess $positions
     * @param array              $positionsDto
     * @param double             $total
     */
    protected function buildPositionsDtoAndCalculatePrices(ArrayAccess $positions, &$positionsDto, &$total)
    {
        /** @var BasketPosition $position */
        foreach ($positions as $position) {
            $positionPrice  = $position->getArticle()->getPrice() * $position->getCount();
            $positionsDto[] = array(
                'articleId'    => $position->getArticle()->getId(),
                'articleTitle' => $position->getArticle()->getTitle(),
                'articlePrice' => PriceFormatter::format($position->getArticle()->getPrice()),
                'articleImage' => $position->getArticle()->getImagePath(),
                'totalPrice'   => PriceFormatter::format($positionPrice),
                'count'        => $position->getCount(),
            );
            $total += $positionPrice;
        }
    }
}
