<?php

namespace App\Contracts;

use App\DTOs\OrderRequestDTO;
use App\Models\Order;

interface OrderServiceInterface
{
    public function createOrder(OrderRequestDTO $orderRequest): Order;
} 