<?php

namespace App\UseCases\Products;

use App\Models\DTOs\RequestProductDTO;
use App\Models\Product;
use App\Repositories\Contracts\Product\RegisterProductRepositoryInterface;

class RegisterProductUseCase
{
    private const IVA_COLOMBIA = 16;

    private const PRICE_MINIMUM = 1.000;

    private const PRICE_MAX = 10.000;

    private const DISCOUNT_MINIMUM = 10;

    private const DISCOUNT_MEDIUM = 15;

    private const DISCOUNT_MAX = 20;

    private const DISCOUNT_TOP = 30;

    private const WITHOUT_DISCOUNT = 0;

    public function __construct(
        private RegisterProductRepositoryInterface $productRegisterRepository)
    {
    }

    public function execute(RequestProductDTO $productDTO): Product
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

        return $this->productRegisterRepository->create($productData);
    }

    // Validación final para que el descuento nunca sea mayor a 30
    private function calculateDiscountByTaxRate(float $price, float $discount, float $taxRate): float
    {
        // Solo si el valor de $taxRate es mayor al valor del IVA colombiano el descuento será efectivo
        if ($taxRate > self::IVA_COLOMBIA) {
            return $discount;
        }

        // El descuento nunca podrá ser mayor al valor máximo de descuento definido
        if ($discount > self::DISCOUNT_TOP) {
            return self::DISCOUNT_TOP;
        }

        // El descuento mayor al valor del descuento mínimo cuando el precio sea menor al valor del precio mínimo
        // siempre será el valor del descuento mínimo
        if ($price < self::PRICE_MINIMUM && $discount > self::DISCOUNT_MINIMUM) {
            return self::DISCOUNT_MINIMUM;
        }

        // Solo si el precio esta definido entre el valor mínimo y máximo de precios y el descuento llegará a ser
        // mayor que el descuento medio, el valor del descuento, será el del valor del descuento medio definido
        if ($price >= self::PRICE_MINIMUM && $price <= self::PRICE_MAX && $discount > self::DISCOUNT_MEDIUM) {
            return self::DISCOUNT_MEDIUM;
        }

        // Siempre que el descuento sea mayor que el valor del descuento máximo y el precio sea mayor que el valor
        // del precio máximo, el descuento será igual al valor del descuento máximo definido
        if ($price > self::PRICE_MAX && $discount > self::DISCOUNT_MAX) {
            return self::DISCOUNT_MAX;
        }

        return self::WITHOUT_DISCOUNT;
    }

    private function calculateDiscountByPrice(float $price, float $discount): float
    {
        if ($discount == 0) {
            return 0;
        }

        return $price - ($price * ($discount / 100));
    }

    private function calculateTaxAmount(float $discountedPrice, float $taxRate): float
    {
        if ($taxRate == 0) {
            return 0;
        }

        return $discountedPrice * ($taxRate / 100);
    }
}
