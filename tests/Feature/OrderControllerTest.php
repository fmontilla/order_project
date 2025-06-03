<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private Product $product1;
    private Product $product2;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->product1 = Product::create([
            'name' => 'Test Product 1',
            'description' => 'Test Description 1',
            'price' => 50.00,
            'stock' => 10
        ]);

        $this->product2 = Product::create([
            'name' => 'Test Product 2',
            'description' => 'Test Description 2',
            'price' => 75.00,
            'stock' => 5
        ]);
    }

    public function test_create_order_successfully(): void
    {
        $payload = [
            'customer_email' => 'test@example.com',
            'payment_method' => 'credit_card',
            'payment_data' => [
                'cc_number' => 2720610441539922,
                'cc_expiry' => '09/25',
                'cc_cvv' => 922,
                'cc_customer_name' => 'Jordy Williamson'
            ],
            'items' => [
                ['product_id' => $this->product1->id, 'quantity' => 2],
                ['product_id' => $this->product2->id, 'quantity' => 1]
            ]
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Order created successfully'
                ])
                ->assertJsonStructure([
                    'data' => [
                        'order_id',
                        'customer_email',
                        'payment_id',
                        'items'
                    ]
                ]);

        $this->assertDatabaseHas('orders', [
            'customer_email' => 'test@example.com'
        ]);

        $this->assertDatabaseHas('order_itens', [
            'product_id' => $this->product1->id,
            'quantity' => 2
        ]);
    }

    public function test_create_order_with_invalid_email(): void
    {
        $payload = [
            'customer_email' => 'invalid-email',
            'payment_method' => 'credit_card',
            'payment_data' => [
                'cc_number' => 2720610441539922,
                'cc_expiry' => '09/25',
                'cc_cvv' => 922,
                'cc_customer_name' => 'Jordy Williamson'
            ],
            'items' => [
                ['product_id' => $this->product1->id, 'quantity' => 2]
            ]
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(422);
    }

    public function test_create_order_with_nonexistent_product(): void
    {
        $payload = [
            'customer_email' => 'test@example.com',
            'payment_method' => 'credit_card',
            'payment_data' => [
                'cc_number' => 2720610441539922,
                'cc_expiry' => '09/25',
                'cc_cvv' => 922,
                'cc_customer_name' => 'Jordy Williamson'
            ],
            'items' => [
                ['product_id' => 999, 'quantity' => 1]
            ]
        ];

        $response = $this->postJson('/api/orders', $payload);

        $response->assertStatus(422);
    }
} 