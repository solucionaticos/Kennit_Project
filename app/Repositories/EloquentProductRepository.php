<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function __construct(private JsonResponseInterface $jsonResponse)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            /** @var Product $products */
            $products = Product::all()->toArray(); // Esto devuelve un array

            // Convertir el array a una colección
            $productsCollection = collect($products);

            $data = $productsCollection->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock' => $item['stock'],
                    'created_at' => \Carbon\Carbon::parse($item['created_at'])->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::parse($item['updated_at'])->toDateTimeString(),
                ];
            });

            return $this->jsonResponse->success($data, 'Products successfully listed.');

        } catch (Exception $e) {
            return $this->jsonResponse->error('Error getting all products: '.$e->getMessage());
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            /** @var Product $product */
            $product = Product::query()->findOrFail($id);

            return $this->jsonResponse->success($product, 'Product found.');

        } catch (Exception $e) {
            return $this->jsonResponse->error('Error getting product', $e->getMessage());
        }
    }

    public function create(array $data): JsonResponse
    {
        try {
            /** @var Product $product */
            $product = Product::query()->create($data);

            return $this->jsonResponse->success($product, 'Successfully created product.');

        } catch (Exception $e) {
            return $this->jsonResponse->error('Error creating product', $e->getMessage());
        }
    }

    public function update(int $id, array $data): JsonResponse
    {
        try {
            /** @var Product $product */
            $product = Product::query()->findOrFail($id);
            $product->update($data);

            return $this->jsonResponse->success($product, 'Successfully updated product.');
        } catch (Exception $e) {
            return $this->jsonResponse->error('Error updating product', $e->getMessage());
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            /** @var \App\Models\Product|null $product */
            $product = Product::query()->find($id);

            if (! $product) {
                return $this->jsonResponse->error('Product not found.', 'The product with ID: '.$id.' does not exist.');
            }

            $data = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'created_at' => $product->created_at->toDateTimeString(),
                'updated_at' => $product->updated_at->toDateTimeString(),
            ];

            $deleted = $product->delete();

            if ($deleted) {
                return $this->jsonResponse->success($data, 'Successfully deleted product.');
            } else {
                return $this->jsonResponse->error('Error deleting product', 'The product could not be deleted.');
            }
        } catch (Exception $e) {
            return $this->jsonResponse->error('Error deleting product', $e->getMessage());
        }
    }
}
