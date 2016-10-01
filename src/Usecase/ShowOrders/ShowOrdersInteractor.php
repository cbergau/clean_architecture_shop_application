<?php

namespace Bws\Usecase\ShowOrders;

use Bws\Entity\Address;
use Bws\Entity\BasketPosition;
use Bws\Entity\Order;
use Bws\Repository\OrderRepository;

class ShowOrdersInteractor
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param $customerId
     *
     * @return ShowOrdersResponse
     */
    public function execute($customerId)
    {
        $orders = $this->orderRepository->findByUserId($customerId);
        $response = new ShowOrdersResponse();

        foreach ($orders as $order) {
            $presentableOrder = new PresentableOrder();
            $presentableOrder->totalValue = '39,99 €';
            $presentableOrder->number = $order->getId();

            $this->putBasketPositionsInResponse($order, $presentableOrder);

            $presentableOrder->invoiceAddress  = $this->getPresentableArrayFromAddress($order->getInvoiceAddress());
            $presentableOrder->deliveryAddress = $this->getPresentableArrayFromAddress($order->getDeliveryAddress());

            $response->presentableOrders[] = $presentableOrder;
        }

        return $response;
    }

    /**
     * @param Address $address
     *
     * @return array
     */
    private function getPresentableArrayFromAddress(Address $address)
    {
        return array(
            'firstName' => $address->getFirstName(),
            'lastName' => $address->getLastName(),
            'street' => $address->getStreet(),
            'zip' => $address->getZip(),
            'city' => $address->getCity(),
        );
    }

    /**
     * @param Order $order
     * @param $presentableOrder
     */
    private function putBasketPositionsInResponse(Order $order, $presentableOrder)
    {
        /** @var BasketPosition $position */
        foreach ($order->getBasket()->getPositions() as $position) {
            $article = $position->getArticle();
            $positions = array(
                'article' => array(
                    'title' => $article->getTitle(),
                    'imagePath' => $article->getImagePath(),
                    'price' => $article->getPrice() . ' €',
                ),
                'value' => $position->getCount() * $article->getPrice() . ' €',
                'quantity' => 2
            );

            $presentableOrder->positions[] = $positions;
        }
    }
}
