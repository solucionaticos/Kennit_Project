<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Models\DTOs\RequestProductDTO;
use App\Services\Contracts\JsonResponseInterface;
use App\Services\LaravelValidationUpdateProduct;
use App\UseCases\Products\UpdateProductUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateProductController extends Controller
{
    public function __construct(
        private LaravelValidationUpdateProduct $validationUpdateProduct,
        private UpdateProductUseCase $updateProductUseCase,
        private JsonResponseInterface $jsonResponse)
    {
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request, int $productId): JsonResponse
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
}
