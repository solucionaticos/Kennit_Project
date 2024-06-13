<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use App\Services\Contracts\ValidationUserInterface;
use App\Services\Contracts\EncryptionInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StoreUserController extends Controller {

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly JsonResponseInterface $jsonResponse,
        private readonly ValidationUserInterface $validation,
        private readonly EncryptionInterface $encryption) 
    {}

    public function __invoke(Request $request): JsonResponse  
    {
        $validatedData = $this->validation->validate($request->all());

        if ($validatedData instanceof JsonResponse) {
            return $validatedData;
        }

        $validatedData['password'] = $this->encryption->encrypt($validatedData['password']);

        $user = $this->userRepository->create($validatedData);
        return $this->jsonResponse->success($user, 'User created successfully', 201);
    }

}
