<?php

namespace App\DTOs;

class PaymentRequestDTO
{
    public function __construct(
        public readonly string $paymentMethod,
        public readonly array $paymentData,
        public readonly float $amount,
        public readonly string $customerEmail
    ) {}
} 