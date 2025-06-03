<?php

namespace App\DTOs;

use App\Models\Order;

class EmailRequestDTO
{
    public function __construct(
        public readonly string $customerEmail,
        public readonly Order $order
    ) {}
} 