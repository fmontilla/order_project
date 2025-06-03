<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function createOrderItem(int $orderId, array $itemData): OrderItem
    {
        $itemData['order_id'] = $orderId;
        return OrderItem::create($itemData);
    }

    public function findById(int $id): ?Order
    {
        return Order::with(['items', 'payment'])->find($id);
    }
} 