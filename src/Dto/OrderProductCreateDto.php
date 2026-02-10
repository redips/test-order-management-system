<?php

namespace App\Dto;

use Symfony\Component\TypeInfo\Type;
use Symfony\Component\Validator\Constraints as Assert;


readonly class OrderProductCreateDto
{

    public function __construct(
        #[Assert\NotBlank]
        public string $productCode,
        #[Assert\NotBlank]
        public string $productName,
        #[Assert\Positive]
        public float $price,
        #[Assert\Positive]
        public int $quantity,
    ) {}
}
