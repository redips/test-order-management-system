<?php

namespace App\Dto;

use App\Entity\Order;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\SerializedName;

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

        /** @var OrderProductCreateDto[] $orderProducts */
        #[SerializedName('products')]
        #[Context([
            'json' => [
                'type' => 'array<App\Dto\OrderProductCreateDto>',
            ],
        ])]
        #[Assert\Valid]
        public array $orderProducts = [],
    ) {}

    public function getCustomerName(): string
    {
        return $this->customerName ?? '';
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber ?? '';
    }

    public function getCustomerCode(): string
    {
        return $this->customerCode ?? '';
    }

    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }
    
}
