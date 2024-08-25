<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    /**
     * Create a new product.
     *
     * @param  array<string, string>  $productData  The data for the product to be created.
     * @return Product The created product instance.
     */
    public function create(array $productData): Product;

    /**
     * Get all products.
     *
     * @return Collection<Product> A collection of all products.
     */
    public function getAll(): Collection;

    /**
     * Get a single product by its ID.
     *
     * @param  int  $productId  The ID of the product to retrieve.
     * @return Product The product with the specified ID.
     */
    public function getOne(int $productId): Product;

    /**
     * Update an existing product.
     *
     * @param  int  $productId  The ID of the product to update.
     * @param  array<string, string>  $productData  The new data for the product.
     * @return Product The updated product instance.
     */
    public function update(int $productId, array $productData): Product;

    /**
     * Delete a product by its ID.
     *
     * @param  int  $productId  The ID of the product to delete.
     * @return bool True if the product was successfully deleted, false otherwise.
     */
    public function delete(int $productId): bool;
}
