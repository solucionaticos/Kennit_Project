<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Contracts\Product\GetAllProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentGetAllProductRepository implements GetAllProductRepositoryInterface
{
    public function getAll(): Collection
    {
        /** @var Product $products */
        $products = Product::all();

        if ($products === null) {
            throw new ModelNotFoundException('Products not found');
        }

        return $products;
    }
}
