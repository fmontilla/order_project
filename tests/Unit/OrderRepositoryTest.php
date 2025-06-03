<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private OrderRepository $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = new OrderRepository();
    }

    public function test_create_order(): void
    {
        $payment = Payment::create([
            'payment_method' => 'credit_card',
            'cc_number' => '123456789',
            'cc_expiry' => '12/25',
            'cc_cvv' => '123',
            'cc_customer_name' => 'Test User'
        ]);

        $orderData = [
            'customer_email' => 'test@example.com',
            'payment_id' => $payment->id
        ];

        $order = $this->orderRepository->create($orderData);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals('test@example.com', $order->customer_email);
        $this->assertEquals($payment->id, $order->payment_id);
    }

    public function test_create_order_item(): void
    {
        $payment = Payment::create([
            'payment_method' => 'credit_card',
            'cc_number' => '123456789',
            'cc_expiry' => '12/25',
            'cc_cvv' => '123',
            'cc_customer_name' => 'Test User'
        ]);

        $order = Order::create([
            'customer_email' => 'test@example.com',
            'payment_id' => $payment->id
        ]);

        Product::create([
            'name' => 'Test Product',
            'price' => 50.00,
            'stock' => 10
        ]);

        $itemData = [
            'product_id' => 1,
            'quantity' => 2
        ];

        $orderItem = $this->orderRepository->createOrderItem($order->id, $itemData);

        $this->assertEquals($order->id, $orderItem->order_id);
        $this->assertEquals(1, $orderItem->product_id);
        $this->assertEquals(2, $orderItem->quantity);
    }

    public function test_find_by_id_with_relations(): void
    {
        $payment = Payment::create([
            'payment_method' => 'credit_card',
            'cc_number' => '123456789',
            'cc_expiry' => '12/25',
            'cc_cvv' => '123',
            'cc_customer_name' => 'Test User'
        ]);

        $order = Order::create([
            'customer_email' => 'test@example.com',
            'payment_id' => $payment->id
        ]);

        $foundOrder = $this->orderRepository->findById($order->id);

        $this->assertInstanceOf(Order::class, $foundOrder);
        $this->assertTrue($foundOrder->relationLoaded('items'));
        $this->assertTrue($foundOrder->relationLoaded('payment'));
    }
} 