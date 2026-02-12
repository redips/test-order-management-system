<?php

namespace App\Application\Factory;

use App\Dto\OrderCreateDto;
use App\Dto\OrderDtoInterface;
use App\Dto\OrderUpdateDto;
use App\Entity\Order;
use App\Entity\OrderProduct;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

class OrderFactory
{
    public function __construct(
        private ObjectMapperInterface $objectMapper
    ) {
    }

    // public function createFromDto(OrderCreateDto $dto): Order {
    public function createFromDto(OrderDtoInterface $dto): Order
    {
        $order = new Order();
        $order->setCustomerCode($dto->customerCode);
        $order->setCustomerName($dto->customerName);
        $order->setOrderNumber($dto->orderNumber);
        $order->setCreatedAt(new \DateTime());

        /** OrderProductCreateDto $productDto */
        foreach ($dto->orderProducts as $productDto) {
            $orderProduct = new OrderProduct();
            $orderProduct->setOrder($order);
            $orderProduct->setProductCode($productDto->productCode);
            $orderProduct->setProductName($productDto->productName);
            $orderProduct->setPrice((float) $productDto->price);
            $orderProduct->setQuantity((int) $productDto->quantity);
            $order->addOrderProduct($orderProduct);
        }

        return $order;
    }

    public function updateFromDto(Order $order, OrderUpdateDto $dto): Order
    {
        if (null !== $dto->orderNumber) {
            $order->setOrderNumber($dto->orderNumber);
        }
        if (null !== $dto->customerCode) {
            $order->setCustomerCode($dto->customerCode);
        }
        if (null !== $dto->customerName) {
            $order->setCustomerName($dto->customerName);
        }

        $order->setCreatedAt(new \DateTime());

        // Gestisci i prodotti separatamente
        if (! empty($dto->getOrderProducts())) {
            // Rimuovi prodotti esistenti
            foreach ($order->getOrderProducts() as $product) {
                $order->removeOrderProduct($product);
            }

            // Aggiungi nuovi prodotti
            foreach ($dto->getOrderProducts() as $productDto) {
                $orderProduct = new OrderProduct();
                $orderProduct->setOrder($order);
                $orderProduct->setProductCode($productDto->productCode);
                $orderProduct->setProductName($productDto->productName);
                $orderProduct->setPrice((float) $productDto->price);
                $orderProduct->setQuantity((int) $productDto->quantity);
                $order->addOrderProduct($orderProduct);
            }
        }

        return $order;
    }
}
