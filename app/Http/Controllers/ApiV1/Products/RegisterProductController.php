<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Models\DTOs\RequestProductDTO;
use App\Services\Contracts\JsonResponseInterface;
use App\Services\LaravelValidationCreateProduct;
use App\UseCases\Products\RegisterProductUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterProductController extends Controller
{
    public function __construct(
        private LaravelValidationCreateProduct $validationCreateProduct,
        private RegisterProductUseCase $registerProductUseCase,
        private JsonResponseInterface $jsonResponse)
    {
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
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
}
