<?php

namespace App\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;
    public function findByIds(array $ids): array;
} 