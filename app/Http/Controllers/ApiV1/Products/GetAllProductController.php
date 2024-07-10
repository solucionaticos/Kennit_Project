<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;

class GetAllProductController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $productRepository)
    {
    }

    public function __invoke(): JsonResponse
    {
        return $this->productRepository->getAll();
    }
}
