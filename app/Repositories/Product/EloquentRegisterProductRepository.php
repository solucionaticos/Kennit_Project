<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Contracts\Product\RegisterProductRepositoryInterface;

class EloquentRegisterProductRepository implements RegisterProductRepositoryInterface
{
    public function create(array $productData): Product
    {
        /** @var Product $product */
        $product = Product::query()->create($productData);

        return $product;
    }
}
