<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Sample Order 1
        $order1 = new Order();
        $order1->setOrderNumber('ORD-2024-001');
        $order1->setCustomerCode('CUST-001');
        $order1->setCustomerName('Acme Corporation');
        $order1->setCreatedAt(new \DateTime('2024-02-01 10:30:00'));

        $product1 = new OrderProduct();
        $product1->setProductCode('LAPTOP-PRO-15');
        $product1->setProductName('Professional Laptop 15"');
        $product1->setPrice('1299.99');
        $product1->setQuantity(2);
        $order1->addOrderProduct($product1);

        $product2 = new OrderProduct();
        $product2->setProductCode('MOUSE-WIRELESS');
        $product2->setProductName('Wireless Mouse');
        $product2->setPrice('29.99');
        $product2->setQuantity(3);
        $order1->addOrderProduct($product2);

        $manager->persist($order1);

        // Sample Order 2
        $order2 = new Order();
        $order2->setOrderNumber('ORD-2024-002');
        $order2->setCustomerCode('CUST-002');
        $order2->setCustomerName('Tech Solutions Inc');
        $order2->setCreatedAt(new \DateTime('2024-02-02 14:15:00'));

        $product3 = new OrderProduct();
        $product3->setProductCode('MONITOR-27');
        $product3->setProductName('27" 4K Monitor');
        $product3->setPrice('399.99');
        $product3->setQuantity(4);
        $order2->addOrderProduct($product3);

        $product4 = new OrderProduct();
        $product4->setProductCode('KEYBOARD-MECH');
        $product4->setProductName('Mechanical Keyboard');
        $product4->setPrice('149.99');
        $product4->setQuantity(4);
        $order2->addOrderProduct($product4);

        $manager->persist($order2);

        // Sample Order 3
        $order3 = new Order();
        $order3->setOrderNumber('ORD-2024-003');
        $order3->setCustomerCode('CUST-003');
        $order3->setCustomerName('Digital Dynamics LLC');
        $order3->setCreatedAt(new \DateTime('2024-02-03 09:45:00'));

        $product5 = new OrderProduct();
        $product5->setProductCode('HEADSET-PRO');
        $product5->setProductName('Professional Headset');
        $product5->setPrice('89.99');
        $product5->setQuantity(10);
        $order3->addOrderProduct($product5);

        $manager->persist($order3);

        // Sample Order 4
        $order4 = new Order();
        $order4->setOrderNumber('ORD-2024-004');
        $order4->setCustomerCode('CUST-001');
        $order4->setCustomerName('Acme Corporation');
        $order4->setCreatedAt(new \DateTime('2024-02-04 16:20:00'));

        $product6 = new OrderProduct();
        $product6->setProductCode('DESK-STANDING');
        $product6->setProductName('Standing Desk Electric');
        $product6->setPrice('599.99');
        $product6->setQuantity(1);
        $order4->addOrderProduct($product6);

        $product7 = new OrderProduct();
        $product7->setProductCode('CHAIR-ERGONOMIC');
        $product7->setProductName('Ergonomic Office Chair');
        $product7->setPrice('349.99');
        $product7->setQuantity(1);
        $order4->addOrderProduct($product7);

        $manager->persist($order4);

        // Sample Order 5
        $order5 = new Order();
        $order5->setOrderNumber('ORD-2024-005');
        $order5->setCustomerCode('CUST-004');
        $order5->setCustomerName('Innovation Hub');
        $order5->setCreatedAt(new \DateTime('2024-02-05 11:00:00'));

        $product8 = new OrderProduct();
        $product8->setProductCode('WEBCAM-HD');
        $product8->setProductName('HD Webcam 1080p');
        $product8->setPrice('79.99');
        $product8->setQuantity(5);
        $order5->addOrderProduct($product8);

        $product9 = new OrderProduct();
        $product9->setProductCode('MICROPHONE-USB');
        $product9->setProductName('USB Studio Microphone');
        $product9->setPrice('129.99');
        $product9->setQuantity(3);
        $order5->addOrderProduct($product9);

        $product10 = new OrderProduct();
        $product10->setProductCode('CABLE-HDMI');
        $product10->setProductName('HDMI Cable 2m');
        $product10->setPrice('12.99');
        $product10->setQuantity(10);
        $order5->addOrderProduct($product10);

        $manager->persist($order5);

        $manager->flush();
    }
}
