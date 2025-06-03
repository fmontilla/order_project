<?php

namespace App\Services;

use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;
use App\Contracts\PaymentServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\DTOs\OrderRequestDTO;
use App\DTOs\PaymentRequestDTO;
use App\Models\Order;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        private PaymentServiceInterface $paymentService,
        private OrderRepositoryInterface $orderRepository,
        private ProductRepositoryInterface $productRepository
    ) {}

    public function createOrder(OrderRequestDTO $orderRequest): Order
    {
        $totalAmount = $this->calculateTotalAmount($orderRequest->items);

        $paymentRequest = new PaymentRequestDTO(
            paymentMethod: $orderRequest->paymentMethod,
            paymentData: $orderRequest->paymentData,
            amount: $totalAmount,
            customerEmail: $orderRequest->customerEmail
        );

        $paymentResponse = $this->paymentService->processPayment($paymentRequest);

        if (!$paymentResponse->success) {
            throw new \Exception('Payment failed: ' . $paymentResponse->errorMessage);
        }

        $order = $this->orderRepository->create([
            'customer_email' => $orderRequest->customerEmail,
            'payment_id' => $paymentResponse->transactionId,
        ]);

        foreach ($orderRequest->items as $item) {
            $this->orderRepository->createOrderItem($order->id, [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return $this->orderRepository->findById($order->id);
    }

    private function calculateTotalAmount(array $items): float
    {
        $total = 0.0;
        
        foreach ($items as $item) {
            $product = $this->productRepository->findById($item['product_id']);
            if ($product) {
                $total += $product->price * $item['quantity'];
            }
        }

        return $total;
    }
} 