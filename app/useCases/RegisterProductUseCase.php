<?php

namespace App\useCases;

use App\Models\DTOs\ProductDTO;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class RegisterProductUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository)
    {
    }

    public function execute(ProductDTO $productDTO): Product
    {
        return $this->productRepository->create([
            'name' => $productDTO->getName(),
            'description' => $productDTO->getDescription(),
            'price' => $productDTO->getPrice(),
            'stock' => $productDTO->getStock(),
        ]);
    }
}
