<?php

namespace App\UseCases\Products;

use App\Models\DTOs\RequestProductDTO;
use App\Models\Product;
use App\Repositories\Contracts\Product\UpdateProductRepositoryInterface;

class UpdateProductUseCase
{
    private const IVA_COLOMBIA = 16;

    private const PRICE_MINIMUM = 1.000;

    private const PRICE_MAX = 10.000;

    private const DISCOUNT_MINIMUM = 10;

    private const DISCOUNT_MEDIUM = 15;

    private const DISCOUNT_MAX = 20;

    private const DISCOUNT_TOP = 30;

    private const WITHOUT_DISCOUNT = 0;

    public function __construct(private UpdateProductRepositoryInterface $productUpdateRepository)
    {
    }

    public function execute(int $id, RequestProductDTO $productDTO): Product
    {
        $price = $productDTO->getPrice();
        $discount = $productDTO->getDiscount();
        $taxRate = $productDTO->getTaxRate();

        $discount = $this->calculateDiscountByTaxRate($price, $discount, $taxRate);

        // Calcular el precio final y el monto del impuesto
        $discountedPrice = $this->calculateDiscountByPrice($price, $discount);
        $taxAmount = $this->calculateTaxAmount($discountedPrice, $taxRate);
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

        return $this->productUpdateRepository->update($id, $productData);
    }

    private function calculateDiscountByTaxRate(float $price, float $discount, float $taxRate): float
    {
        if ($taxRate > self::IVA_COLOMBIA) {
            return $discount;
        }

        if ($discount > self::DISCOUNT_TOP) {
            return self::DISCOUNT_TOP;
        }

        if ($price < self::PRICE_MINIMUM && $discount > self::DISCOUNT_MINIMUM) {
            return self::DISCOUNT_MINIMUM;
        }

        if ($price >= self::PRICE_MINIMUM && $price <= self::PRICE_MAX && $discount > self::DISCOUNT_MEDIUM) {
            return self::DISCOUNT_MEDIUM;
        }

        if ($price > self::PRICE_MAX && $discount > self::DISCOUNT_MAX) {
            return self::DISCOUNT_MAX;
        }

        return self::WITHOUT_DISCOUNT;
    }

    private function calculateDiscountByPrice(float $price, float $discount): float
    {
        return $price - ($price * ($discount / 100));
    }

    private function calculateTaxAmount(float $discountedPrice, float $taxRate): float
    {
        return $discountedPrice * ($taxRate / 100);
    }
}
