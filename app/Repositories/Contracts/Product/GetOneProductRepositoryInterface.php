<?php

namespace App\Repositories\Contracts\Product;

use App\Models\Product;

interface GetOneProductRepositoryInterface
{
    public function getOne(int $productId): Product;
}
