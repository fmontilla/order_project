<?php

namespace App\DTOs;

class PaymentResponseDTO
{
    public function __construct(
        public readonly bool $success,
        public readonly string $transactionId,
        public readonly ?string $errorMessage = null
    ) {}
} 