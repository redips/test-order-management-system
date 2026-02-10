<?php

namespace App\Dto;

use App\Entity\Order;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Order::class)]
class OrderUpdateDto implements OrderDtoInterface
{
    public function __construct(
        #[Assert\NotBlank(allowNull: true)]
        public ?string $orderNumber = null,

        #[Assert\NotBlank(allowNull: true)]
        public ?string $customerCode = null,

        #[Assert\NotBlank(allowNull: true)]
        public ?string $customerName = null,

        #[Assert\Valid]
        public array $orderProducts = [],
    ) {}

    public function getOrderNumber(): string
    {
        return $this->orderNumber ?? '';
    }
    public function getCustomerCode(): string
    {
        return $this->customerCode ?? '';
    }
    public function getCustomerName(): string
    {
        return $this->customerName ?? '';
    }
    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }
}
