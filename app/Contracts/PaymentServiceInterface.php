<?php

namespace App\Contracts;

use App\DTOs\PaymentRequestDTO;
use App\DTOs\PaymentResponseDTO;

interface PaymentServiceInterface
{
    public function processPayment(PaymentRequestDTO $paymentRequest): PaymentResponseDTO;
} 