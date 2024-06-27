<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\DTOs\ProductDTO;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use App\Services\LaravelValidationProduct;
use App\useCases\RegisterProductUseCase;
use App\useCases\UpdateProductUseCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private JsonResponseInterface $jsonResponse,
        private LaravelValidationProduct $validationProduct,
        private ProductRepositoryInterface $productRepository,
        private RegisterProductUseCase $registerProduct,
        private UpdateProductUseCase $updateProduct)
    {
    }

    public function getAll(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function show(int $id): Product
    {
        return $this->productRepository->show($id);
    }

    public function create(Request $request): JsonResponse
    {
        $validatedData = $this->validationProduct->validate($request->all());

        $productDTO = new ProductDTO();
        $productDTO->setName($validatedData['name']);
        $productDTO->setDescription($validatedData['description']);
        $productDTO->setPrice($validatedData['price']);
        $productDTO->setStock($validatedData['stock']);

        $product = $this->registerProduct->execute($productDTO);

        return $this->jsonResponse->success($product, 'Product created successfully', 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {

        $validatedData = $this->validationProduct->validate($request->all());

        $productDTO = new ProductDTO();
        $productDTO->setName($validatedData['name']);
        $productDTO->setDescription($validatedData['description']);
        $productDTO->setPrice($validatedData['price']);
        $productDTO->setStock($validatedData['stock']);

        $product = $this->updateProduct->execute($id, $productDTO);

        return $this->jsonResponse->success($product, 'Product updated successfully', 201);
    }

    public function delete(int $id): JsonResponse
    {
        $this->productRepository->delete($id);

        return $this->jsonResponse->success("ID: $id", 'Product deleted successfully', 201);
    }
}
