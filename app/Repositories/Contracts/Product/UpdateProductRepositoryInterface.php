<?php

namespace App\Repositories\Contracts\Product;

use App\Models\Product;

interface UpdateProductRepositoryInterface
{
    public function update(int $productId, array $productData): Product;
}
