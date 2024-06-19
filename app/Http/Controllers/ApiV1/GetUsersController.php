<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUsersController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly JsonResponseInterface $jsonResponse
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $users = $this->userRepository->getAll();

        return $this->jsonResponse->success($users);
    }
}
