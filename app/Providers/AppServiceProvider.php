<?php

namespace App\Providers;

use App\Contracts\EmailServiceInterface;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\OrderServiceInterface;
use App\Contracts\PaymentRepositoryInterface;
use App\Contracts\PaymentServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Services\EmailService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        
        $this->app->bind(PaymentServiceInterface::class, PaymentService::class);
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
