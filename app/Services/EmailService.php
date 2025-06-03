<?php

namespace App\Services;

use App\Contracts\EmailServiceInterface;
use App\DTOs\EmailRequestDTO;
use Illuminate\Support\Facades\Log;

class EmailService implements EmailServiceInterface
{
    public function sendOrderConfirmation(EmailRequestDTO $emailRequest): bool
    {
        Log::info('Sending order confirmation email', [
            'customer_email' => $emailRequest->customerEmail,
            'order_id' => $emailRequest->order->id,
            'items_count' => $emailRequest->order->items->count()
        ]);

        return true;
    }
} 