<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Product\DeleteProductRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteProductController extends Controller
{
    public function __construct(
        private DeleteProductRepositoryInterface $deleteProductRepository,
        private JsonResponseInterface $jsonResponse)
    {
    }

    public function __invoke(int $productId): JsonResponse
    {
        try {
            $this->deleteProductRepository->delete($productId);

            return $this->jsonResponse->success(null, 'Record deleted successfully.');
        } catch (Exception $e) {
            return $this->jsonResponse->error('Error deleting product', $e->getMessage());
        }
    }
}
