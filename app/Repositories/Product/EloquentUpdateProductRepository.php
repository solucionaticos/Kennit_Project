<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Contracts\Product\UpdateProductRepositoryInterface;

class EloquentUpdateProductRepository implements UpdateProductRepositoryInterface
{
    public function update(int $productId, array $productData): Product
    {
        /** @var Product $product */
        $product = Product::query()->findOrFail($productId);
        $product->update($productData);

        return $product;
    }
}
