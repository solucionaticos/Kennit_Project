<?php

namespace App\useCases;

use App\Models\DTOs\ProductDTO;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class UpdateProductUseCase
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function execute(int $id, ProductDTO $productDTO): Product
    {
        $productData = [
            'name' => $productDTO->getName(),
            'description' => $productDTO->getDescription(),
            'price' => $productDTO->getPrice(),
            'stock' => $productDTO->getStock(),
        ];

        return $this->productRepository->update($id, $productData);
    }
}
