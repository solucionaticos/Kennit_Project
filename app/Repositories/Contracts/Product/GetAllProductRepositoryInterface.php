<?php

namespace App\Repositories\Contracts\Product;

use Illuminate\Database\Eloquent\Collection;

interface GetAllProductRepositoryInterface
{
    public function getAll(): Collection;
}
