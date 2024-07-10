<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Models\DTOs\ProductDTO;
use App\Services\LaravelValidationUpdateProduct;
use App\useCases\Products\UpdateProductUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateProductController extends Controller
{
    public function __construct(
        private LaravelValidationUpdateProduct $validationUpdateProduct,
        private UpdateProductUseCase $updateProductUseCase)
    {
    }

    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request, int $id): JsonResponse
    {

        $validatedData = $this->validationUpdateProduct->validate($request->all());

        $productDTO = new ProductDTO();
        $productDTO->setName($validatedData['name']);
        $productDTO->setDescription($validatedData['description']);
        $productDTO->setPrice($validatedData['price']);
        $productDTO->setStock($validatedData['stock']);

        return $this->updateProductUseCase->execute($id, $productDTO);
    }
}
