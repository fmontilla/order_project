<?php

namespace App\Contracts;

use App\Models\Order;
use App\Models\OrderItem;

interface OrderRepositoryInterface
{
    public function create(array $data): Order;
    public function createOrderItem(int $orderId, array $itemData): OrderItem;
    public function findById(int $id): ?Order;
} 