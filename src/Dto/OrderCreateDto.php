<?php

namespace App\Dto;


use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\SerializedName;

class OrderCreateDto implements OrderDtoInterface
{

    public function __construct(
        #[Assert\NotBlank]
        public string $orderNumber,
        #[Assert\NotBlank]
        public string $customerCode,
        #[Assert\NotBlank]
        public string $customerName,
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

    /**
     * Get the value of customerName
     */
    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    /**
     * Get the value of orderNumber
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * Get the value of customerCode
     */
    public function getCustomerCode(): string
    {
        return $this->customerCode;
    }

    /**
     * Get the value of orderProducts
     */
    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }
}
