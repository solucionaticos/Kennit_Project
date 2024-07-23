<?php

namespace App\Repositories\Contracts\Product;

interface DeleteProductRepositoryInterface
{
    public function delete(int $productId): bool;
}
