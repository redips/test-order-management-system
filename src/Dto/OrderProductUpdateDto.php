<?php

namespace App\Dto;

use Doctrine\Common\Collections\Collection;

class OrderProductUpdateDto
{
   public function __construct(
      public ?string $orderNumber,
      public ?string $customerCode,
      public ?string $customerName,
      public Collection $orderProducts,
   ) {}
}
