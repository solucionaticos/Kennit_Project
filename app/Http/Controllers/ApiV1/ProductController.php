<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\DTOs\RequestProductDTO;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use App\Services\LaravelValidationCreateProduct;
use App\Services\LaravelValidationUpdateProduct;
use App\UseCases\Products\RegisterProductUseCase;
use App\UseCases\Products\UpdateProductUseCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private LaravelValidationCreateProduct $validationCreateProduct,
        private RegisterProductUseCase $registerProductUseCase,
        private LaravelValidationUpdateProduct $validationUpdateProduct,
        private UpdateProductUseCase $updateProductUseCase,
        private ProductRepositoryInterface $productRepository,
        private JsonResponseInterface $jsonResponse)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Collection|JsonResponse
    {
        try {
            $products = $this->productRepository->getAll();

            return $this->jsonResponse->success($products, 'Successfully getting all products');
        } catch (ModelNotFoundException $e) {
            return $this->jsonResponse->error('Error getting products', 'Products not found');
        } catch (Exception $e) {
            return $this->jsonResponse->error('Error getting all products', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        try {

            $validatedData = $this->validationCreateProduct->validate($request->all());

            if (is_string($validatedData)) {
                return $this->jsonResponse->error('Error validating product creation', $validatedData);
            }

            $productDTO = new RequestProductDTO();
            $productDTO->setName($validatedData['name']);
            $productDTO->setDescription($validatedData['description']);
            $productDTO->setPrice($validatedData['price']);
            $productDTO->setStock($validatedData['stock']);
            $productDTO->setDiscount($validatedData['discount']);
            $productDTO->setTaxRate($validatedData['tax_rate']);

            $product = $this->registerProductUseCase->execute($productDTO);

            return $this->jsonResponse->success($product, 'Successfully created product.');

        } catch (Exception $e) {
            return $this->jsonResponse->error('Error creating product', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $productId): Product|JsonResponse
    {
        try {
            $product = $this->productRepository->getOne($productId);

            return $this->jsonResponse->success($product, 'Successfully getting the product');
        } catch (ModelNotFoundException $e) {
            return $this->jsonResponse->error('Error getting product', 'Product not found');
        } catch (Exception $e) {
            return $this->jsonResponse->error('Error getting product', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $productId): JsonResponse
    {
        try {
            $validatedData = $this->validationUpdateProduct->validate($request->all());

            if (is_string($validatedData)) {
                return $this->jsonResponse->error('Error validating the product update', $validatedData);
            }

            $productDTO = new RequestProductDTO();
            $productDTO->setName($validatedData['name']);
            $productDTO->setDescription($validatedData['description']);
            $productDTO->setPrice($validatedData['price']);
            $productDTO->setStock($validatedData['stock']);
            $productDTO->setDiscount($validatedData['discount']);
            $productDTO->setTaxRate($validatedData['tax_rate']);

            $product = $this->updateProductUseCase->execute($productId, $productDTO);

            return $this->jsonResponse->success($product, 'Successfully updated product.');

        } catch (Exception $e) {
            return $this->jsonResponse->error('Error updating product', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $productId): JsonResponse
    {
        try {
            $this->productRepository->delete($productId);

            return $this->jsonResponse->success(null, 'Record deleted successfully.');
        } catch (Exception $e) {
            return $this->jsonResponse->error('Error deleting product', $e->getMessage());
        }
    }
}
