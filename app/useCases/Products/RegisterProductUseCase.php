<?php

namespace App\useCases\Products;

use App\Models\DTOs\ProductDTO;
// use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;

class RegisterProductUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository)
    {
    }

    public function execute(ProductDTO $productDTO): JsonResponse
    {
        $productData = [
            'name' => $productDTO->getName(),
            'description' => $productDTO->getDescription(),
            'price' => $productDTO->getPrice(),
            'stock' => $productDTO->getStock(),
        ];

        return $this->productRepository->create($productData);
    }
}
