<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Contracts\Product\GetOneProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentGetOneProductRepository implements GetOneProductRepositoryInterface
{
    public function getOne(int $productId): Product
    {
        /** @var Product $product */
        $product = Product::query()->findOrFail($productId);

        if ($product === null) {
            throw new ModelNotFoundException('Product not found');
        }

        return $product;
    }
}
