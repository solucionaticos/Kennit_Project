<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;

class GetOneProductController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        return $this->productRepository->show($id);
    }
}
