<?php

namespace App\Contracts;

use App\DTOs\EmailRequestDTO;

interface EmailServiceInterface
{
    public function sendOrderConfirmation(EmailRequestDTO $emailRequest): bool;
} 