<?php

namespace App\Http\Controllers\ApiV1\Products;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Product\GetAllProductRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class GetAllProductController extends Controller
{
    public function __construct(
        private GetAllProductRepositoryInterface $getAllProductRepository,
        private JsonResponseInterface $jsonResponse)
    {
    }

    public function __invoke(): Collection|JsonResponse
    {

        try {
            $products = $this->getAllProductRepository->getAll();

            return $this->jsonResponse->success($products, 'Successfully getting all products');
        } catch (ModelNotFoundException $e) {
            return $this->jsonResponse->error('Error getting products', 'Products not found');
        } catch (Exception $e) {
            return $this->jsonResponse->error('Error getting all products', $e->getMessage());
        }

    }
}
