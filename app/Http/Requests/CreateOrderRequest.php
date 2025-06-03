<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_email' => 'required|email',
            'payment_method' => 'required|string|in:credit_card,debit_card,pix',
            'payment_data' => 'required|array',
            'payment_data.cc_number' => 'required_if:payment_method,credit_card,debit_card|numeric',
            'payment_data.cc_expiry' => 'required_if:payment_method,credit_card,debit_card|string',
            'payment_data.cc_cvv' => 'required_if:payment_method,credit_card,debit_card|numeric',
            'payment_data.cc_customer_name' => 'required_if:payment_method,credit_card,debit_card|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
} 