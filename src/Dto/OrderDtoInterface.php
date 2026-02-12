<?php

namespace App\Dto;

interface OrderDtoInterface
{
    public function getOrderNumber(): string;

    public function getCustomerCode(): string;

    public function getCustomerName(): string;

    public function getOrderProducts(): array;
}
