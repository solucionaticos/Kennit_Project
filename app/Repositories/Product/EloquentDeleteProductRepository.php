<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Contracts\Product\DeleteProductRepositoryInterface;

class EloquentDeleteProductRepository implements DeleteProductRepositoryInterface
{
    public function delete(int $productId): bool
    {
        /** @var Product $product */
        $product = Product::query()->findOrFail($productId);
        $product->delete();

        return true;
    }
}
