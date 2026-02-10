<?php

namespace App\Application\Factory;

use App\Dto\OrderCreateDto;
use App\Dto\OrderDtoInterface;
use App\Entity\Order;
use App\Entity\OrderProduct;
use DateTime;

class OrderFactory {

    // public function createFromDto(OrderCreateDto $dto): Order {
    public function createFromDto(OrderDtoInterface $dto): Order {
        $order = new Order();
        $order->setCustomerCode($dto->customerCode);
        $order->setCustomerName($dto->customerName);
        $order->setOrderNumber($dto->orderNumber);
        $order->setCreatedAt(new DateTime());

        /** OrderProductCreateDto $productDto */
        foreach ($dto->orderProducts as $productDto) {
            $orderProduct = new OrderProduct();
            $orderProduct->setOrder($order);
            $orderProduct->setProductCode($productDto->productCode);
            $orderProduct->setProductName($productDto->productName);
            $orderProduct->setPrice((float) $productDto->price);
            $orderProduct->setQuantity((int)$productDto->quantity);
            $order->addOrderProduct($orderProduct);
        }

        return $order;
    }
}
