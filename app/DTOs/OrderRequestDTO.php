<?php

namespace App\DTOs;

class OrderRequestDTO
{
    public function __construct(
        public readonly string $customerEmail,
        public readonly string $paymentMethod,
        public readonly array $paymentData,
        public readonly array $items
    ) {}
} 