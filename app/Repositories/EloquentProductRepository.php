<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function getAll(): Collection
    {
        try {
            return Product::all();
        } catch (Exception $e) {
            throw new Exception('Error al obtener todos los productos: '.$e->getMessage());
        }
    }

    public function show(int $id): Product
    {
        try {
            /** @var Product $product */
            $product = Product::query()->findOrFail($id);

            return $product;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Producto no encontrado: '.$e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Error al mostrar el producto: '.$e->getMessage());
        }
    }

    public function create(array $data): Product
    {
        try {
            /** @var Product $product */
            $product = Product::query()->create($data);

            return $product;
        } catch (Exception $e) {
            throw new Exception('Error al crear el producto: '.$e->getMessage());
        }
    }

    public function update(int $id, array $data): Product
    {
        try {
            /** @var Product $product */
            $product = Product::query()->findOrFail($id);
            $product->update($data);

            return $product;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Producto no encontrado para actualizar: '.$e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Error al actualizar el producto: '.$e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            Product::query()->findOrFail($id)->delete();

            return true;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Producto no encontrado para eliminar: '.$e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Error al eliminar el producto: '.$e->getMessage());
        }
    }
}
