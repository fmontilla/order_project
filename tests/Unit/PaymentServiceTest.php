<?php

namespace Tests\Unit;

use App\DTOs\PaymentRequestDTO;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentService = app(PaymentService::class);
    }

    public function test_process_payment_creates_payment_record(): void
    {
        $paymentRequest = new PaymentRequestDTO(
            paymentMethod: 'credit_card',
            paymentData: [
                'cc_number' => '2720610441539922',
                'cc_expiry' => '09/25',
                'cc_cvv' => '922',
                'cc_customer_name' => 'Jordy Williamson'
            ],
            amount: 100.00,
            customerEmail: 'test@example.com'
        );

        $response = $this->paymentService->processPayment($paymentRequest);

        $this->assertTrue($response->success);
        $this->assertNotEmpty($response->transactionId);
        $this->assertDatabaseHas('payments', [
            'payment_method' => 'credit_card',
            'cc_number' => '2720610441539922',
            'cc_customer_name' => 'Jordy Williamson'
        ]);
    }

    public function test_process_payment_returns_transaction_id(): void
    {
        $paymentRequest = new PaymentRequestDTO(
            paymentMethod: 'credit_card',
            paymentData: [
                'cc_number' => '2720610441539922',
                'cc_expiry' => '09/25',
                'cc_cvv' => '922',
                'cc_customer_name' => 'Jordy Williamson'
            ],
            amount: 100.00,
            customerEmail: 'test@example.com'
        );

        $response = $this->paymentService->processPayment($paymentRequest);

        $payment = Payment::first();
        $this->assertEquals((string) $payment->id, $response->transactionId);
    }
} 