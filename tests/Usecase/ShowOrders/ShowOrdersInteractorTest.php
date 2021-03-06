<?php

namespace Bws\Usecase\ShowOrders;

use Bws\Entity\Address;
use Bws\Entity\Article;
use Bws\Entity\Basket;
use Bws\Entity\BasketPosition;
use Bws\Entity\Customer;
use Bws\Entity\DeliveryAddress;
use Bws\Entity\InvoiceAddress;
use Bws\Repository\BasketPositionRepositoryMock;
use Bws\Repository\BasketRepositoryMock;
use Bws\Usecase\ShowOrders\PresentableOrder;
use Bws\Usecase\ShowOrders\ShowOrdersInteractor;
use Bws\Repository\OrderRepositoryMock;

class ShowOrdersInteractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShowOrdersInteractor
     */
    private $interactor;

    /**
     * @var OrderRepositoryMock
     */
    private $orderRepository;

    /**
     * @var BasketPositionRepositoryMock
     */
    private $basketPositionRepository;

    /**
     * @var BasketRepositoryMock
     */
    private $basketRepository;

    public function setUp()
    {
        $this->orderRepository = new OrderRepositoryMock();
        $this->basketPositionRepository = new BasketPositionRepositoryMock();
        $this->basketRepository = new BasketRepositoryMock();

        $this->interactor = new ShowOrdersInteractor(
            $this->orderRepository,
            $this->basketRepository,
            $this->basketPositionRepository
        );
    }

    public function testExecuteWithoutOrdersShouldReturnEmptyResponse()
    {
        $response = $this->interactor->execute(123456);
        $this->assertEquals(array(), $response->presentableOrders);
    }

    public function testExecuteWithOneOrderShouldReturnAResponseWithOneOrder()
    {
        $order = $this->orderRepository->factory();

        $customer = new Customer();
        $customer->setId(123456);
        $order->setCustomer($customer);

        $invoiceAddress = new InvoiceAddress();
        $invoiceAddress->setFirstName('Max');
        $invoiceAddress->setLastName('Mustermann');
        $invoiceAddress->setStreet('Musterstreet 12');
        $invoiceAddress->setZip('12345');
        $invoiceAddress->setCity('Mustercity');
        $order->setInvoiceAddress($invoiceAddress);

        $deliveryAddress = new DeliveryAddress();
        $deliveryAddress->setFirstName('DeliveryAddressFirstName');
        $deliveryAddress->setLastName('DeliveryAddressLastName');
        $deliveryAddress->setStreet('Musterstreet 12');
        $deliveryAddress->setZip('12345');
        $deliveryAddress->setCity('Mustercity');
        $order->setDeliveryAddress($deliveryAddress);

        $article = new Article();
        $article->setTitle('ArticleTitle');
        $article->setPrice(19.99);
        $article->setImagePath('/path/to/image.png');

        $basketPosition = new BasketPosition();
        $basketPosition->setArticle($article);
        $basketPosition->setCount(1);

        $basket = new Basket();
        $basket->setBasketPositions(array($basketPosition));
        $order->setBasket($basket);

        $this->orderRepository->save($order);
        $this->basketRepository->save($basket);
        $this->basketPositionRepository->addToBasket($basketPosition);

        $response = $this->interactor->execute(123456);

        $this->assertEquals(array(
            'firstName' => 'Max',
            'lastName' => 'Mustermann',
            'street' => 'Musterstreet 12',
            'zip' => '12345',
            'city' => 'Mustercity',
        ), $response->presentableOrders[0]->invoiceAddress);

        $this->assertEquals(array(
            'firstName' => 'DeliveryAddressFirstName',
            'lastName' => 'DeliveryAddressLastName',
            'street' => 'Musterstreet 12',
            'zip' => '12345',
            'city' => 'Mustercity',
        ), $response->presentableOrders[0]->deliveryAddress);

        $this->assertEquals(array(
            'article' => array(
                'title' => 'ArticleTitle',
                'imagePath' => '/path/to/image.png',
                'price' => '19.99 €'
            ),
            'value' => '19.99 €',
            'quantity' => 1
        ), $response->presentableOrders[0]->positions[0]);

        $this->assertEquals('19.99 €', $response->presentableOrders[0]->totalValue);
    }
}
