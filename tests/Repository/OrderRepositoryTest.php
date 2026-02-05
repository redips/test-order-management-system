<?php

namespace App\Tests\Repository;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderRepositoryTest extends KernelTestCase
{
    private ?OrderRepository $repository = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repository = static::getContainer()->get(OrderRepository::class);
    }

    public function testSaveOrder(): void
    {
        $order = new Order();
        $order->setOrderNumber('TEST-' . time());
        $order->setCustomerCode('CUST001');
        $order->setCustomerName('Test Customer');

        $product = new OrderProduct();
        $product->setProductCode('PROD001');
        $product->setProductName('Test Product');
        $product->setPrice('99.99');
        $product->setQuantity(2);
        $order->addOrderProduct($product);

        $this->repository->save($order, true);

        $this->assertNotNull($order->getId());
        $this->assertEquals('CUST001', $order->getCustomerCode());
    }

    public function testFindByFilters(): void
    {
        $order = new Order();
        $order->setOrderNumber('FILTER-TEST-' . time());
        $order->setCustomerCode('FILTER-CUST');
        $order->setCustomerName('Filter Test Customer');

        $this->repository->save($order, true);

        $results = $this->repository->findByFilters(['customerCode' => 'FILTER-CUST']);

        $this->assertNotEmpty($results);
        $this->assertInstanceOf(Order::class, $results[0]);
    }

    public function testGetTotalAmount(): void
    {
        $order = new Order();
        $order->setOrderNumber('TOTAL-TEST-' . time());
        $order->setCustomerCode('TOTAL-CUST');
        $order->setCustomerName('Total Test Customer');

        $product1 = new OrderProduct();
        $product1->setProductCode('PROD001');
        $product1->setProductName('Product 1');
        $product1->setPrice('10.00');
        $product1->setQuantity(2);
        $order->addOrderProduct($product1);

        $product2 = new OrderProduct();
        $product2->setProductCode('PROD002');
        $product2->setProductName('Product 2');
        $product2->setPrice('15.50');
        $product2->setQuantity(3);
        $order->addOrderProduct($product2);

        $expectedTotal = (10.00 * 2) + (15.50 * 3);
        $this->assertEquals($expectedTotal, $order->getTotalAmount());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->repository = null;
    }
}
