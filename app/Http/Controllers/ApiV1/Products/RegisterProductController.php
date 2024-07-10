<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Models\DTOs\ProductDTO;
use App\Services\LaravelValidationCreateProduct;
use App\useCases\Products\RegisterProductUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterProductController extends Controller
{
    public function __construct(
        private LaravelValidationCreateProduct $validationCreateProduct,
        private RegisterProductUseCase $registerProductUseCase)
    {
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $validatedData = $this->validationCreateProduct->validate($request->all());

        $productDTO = new ProductDTO();
        $productDTO->setName($validatedData['name']);
        $productDTO->setDescription($validatedData['description']);
        $productDTO->setPrice($validatedData['price']);
        $productDTO->setStock($validatedData['stock']);

        return $this->registerProductUseCase->execute($productDTO);
    }
}
