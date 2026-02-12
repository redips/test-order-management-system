<?php

namespace App\Service;

use App\Entity\Order;
use App\Exception\OrderNotFoundException;
use App\Repository\OrderRepository;

class OrderDeleteService
{
    public function __construct(
        private OrderRepository $orderRepository,
    ) {
        
    }

    public function deleteOrder(int $id): void
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            throw new OrderNotFoundException();
        }

        $this->orderRepository->remove($order, true);
    }
}