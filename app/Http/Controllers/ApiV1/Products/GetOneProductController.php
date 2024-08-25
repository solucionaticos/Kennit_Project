<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Contracts\Product\GetOneProductRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class GetOneProductController extends Controller
{
    public function __construct(
        private GetOneProductRepositoryInterface $showProductRepository,
        private JsonResponseInterface $jsonResponse)
    {
    }

    public function __invoke(int $productId): Product|JsonResponse
    {

        try {
            $product = $this->showProductRepository->getOne($productId);

            return $this->jsonResponse->success($product, 'Successfully getting the product');
        } catch (ModelNotFoundException $e) {
            return $this->jsonResponse->error('Error getting product', 'Product not found');
        } catch (Exception $e) {
            return $this->jsonResponse->error('Error getting product', $e->getMessage());
        }

    }
}
