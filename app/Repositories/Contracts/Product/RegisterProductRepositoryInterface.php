<?php

namespace App\Repositories\Contracts\Product;

use App\Models\Product;

interface RegisterProductRepositoryInterface
{
    public function create(array $productData): Product;
}
