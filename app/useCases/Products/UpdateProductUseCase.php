<?php

namespace App\useCases\Products;

use App\Models\DTOs\ProductDTO;
// use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UpdateProductUseCase
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    public function execute(int $id, ProductDTO $productDTO): JsonResponse
    {
        $price = $productDTO->getPrice();
        $discount = $productDTO->getDiscount();
        $taxRate = $productDTO->getTaxRate();

        // Validaciones del descuento según el precio y la tasa de impuestos
        if ($taxRate <= 16) {
            if ($price < 1000 && $discount > 10) {
                $discount = 10;
            } elseif ($price >= 1000 && $price <= 10000 && $discount > 15) {
                $discount = 15;
            } elseif ($price > 10000 && $discount > 20) {
                $discount = 20;
            }
        }

        // Validación final para que el descuento nunca sea mayor a 30
        if ($discount > 30) {
            $discount = 30;
        }

        // Calcular el precio final y el monto del impuesto
        $discountedPrice = $price - ($price * ($discount / 100));
        $taxAmount = $discountedPrice * ($taxRate / 100);
        $finalPrice = $discountedPrice + $taxAmount;

        $productData = [
            'name' => $productDTO->getName(),
            'description' => $productDTO->getDescription(),
            'price' => $price,
            'stock' => $productDTO->getStock(),
            'discount' => $discount,
            'final_price' => $finalPrice,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
        ];

        return $this->productRepository->update($id, $productData);
    }
}
