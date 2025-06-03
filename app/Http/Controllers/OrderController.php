<?php

namespace App\Http\Controllers;

use App\Contracts\EmailServiceInterface;
use App\Contracts\OrderServiceInterface;
use App\DTOs\EmailRequestDTO;
use App\DTOs\OrderRequestDTO;
use App\Http\Requests\CreateOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(
        private OrderServiceInterface $orderService,
        private EmailServiceInterface $emailService
    ) {}

    public function store(CreateOrderRequest $request): JsonResponse
    {
        try {
            $orderRequest = new OrderRequestDTO(
                customerEmail: $request->customer_email,
                paymentMethod: $request->payment_method,
                paymentData: $request->payment_data,
                items: $request->items
            );

            $order = $this->orderService->createOrder($orderRequest);

            $emailRequest = new EmailRequestDTO(
                customerEmail: $order->customer_email,
                order: $order
            );

            $this->emailService->sendOrderConfirmation($emailRequest);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order_id' => $order->id,
                    'customer_email' => $order->customer_email,
                    'payment_id' => $order->payment_id,
                    'items' => $order->items->map(function ($item) {
                        return [
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                        ];
                    }),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
