<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentProductRepository implements ProductRepositoryInterface
{
    /**
     * Creates a new product record in the database.
     *
     * @param  array  $productData  Array containing the data for the new product.
     * @return Product The newly created product instance.
     */
    public function create(array $productData): Product
    {
        /** @var Product $product */
        $product = Product::query()->create($productData);

        return $product;
    }

    /**
     * Retrieves all product records from the database.
     *
     * @return Collection A collection of all product instances.
     *
     * @throws ModelNotFoundException If no products are found.
     */
    public function getAll(): Collection
    {
        /** @var Product $products */
        $products = Product::all();

        return $products;
    }

    /**
     * Retrieves a single product record by its ID.
     *
     * @param  int  $productId  The ID of the product to retrieve.
     * @return Product The product instance.
     *
     * @throws ModelNotFoundException If the product is not found.
     */
    public function getOne(int $productId): Product
    {
        /** @var Product $product */
        $product = Product::query()->findOrFail($productId);

        return $product;
    }

    /**
     * Updates an existing product record in the database.
     *
     * @param  int  $productId  The ID of the product to update.
     * @param  array  $productData  Array containing the updated product data.
     * @return Product The updated product instance.
     *
     * @throws ModelNotFoundException If the product is not found.
     */
    public function update(int $productId, array $productData): Product
    {
        /** @var Product $product */
        $product = Product::query()->findOrFail($productId);
        $product->update($productData);

        return $product;
    }

    /**
     * Deletes a product record from the database.
     *
     * @param  int  $productId  The ID of the product to delete.
     * @return bool True if the deletion was successful.
     *
     * @throws ModelNotFoundException If the product is not found.
     */
    public function delete(int $productId): bool
    {
        /** @var Product $product */
        $product = Product::query()->findOrFail($productId);
        $product->delete();

        return true;
    }
}
