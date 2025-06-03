<?php

namespace App\Services;

use App\Contracts\PaymentRepositoryInterface;
use App\Contracts\PaymentServiceInterface;
use App\DTOs\PaymentRequestDTO;
use App\DTOs\PaymentResponseDTO;

class PaymentService implements PaymentServiceInterface
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository
    ) {}

    public function processPayment(PaymentRequestDTO $paymentRequest): PaymentResponseDTO
    {
        $payment = $this->paymentRepository->create([
            'payment_method' => $paymentRequest->paymentMethod,
            'cc_number' => $paymentRequest->paymentData['cc_number'] ?? null,
            'cc_expiry' => $paymentRequest->paymentData['cc_expiry'] ?? null,
            'cc_cvv' => $paymentRequest->paymentData['cc_cvv'] ?? null,
            'cc_customer_name' => $paymentRequest->paymentData['cc_customer_name'] ?? null,
        ]);

        return new PaymentResponseDTO(
            success: true,
            transactionId: (string) $payment->id
        );
    }
} 