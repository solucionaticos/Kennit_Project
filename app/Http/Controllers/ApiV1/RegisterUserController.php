<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\DTOs\UserRegisterDTO;
use App\Services\Contracts\JsonResponseInterface;
use App\Services\LaravelValidationUser;
use App\useCases\RegisterUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function __construct(
        private JsonResponseInterface $jsonResponse,
        private LaravelValidationUser $validation,
        private RegisterUserUseCase $registerUserUseCase
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $validatedData = $this->validation->validate($request->all());

        if ($validatedData instanceof JsonResponse) {
            return $validatedData;
        }

        $userRegister = new UserRegisterDTO();
        $userRegister->setName($validatedData['name']);
        $userRegister->setEmail($validatedData['email']);
        $userRegister->setUserPassword($validatedData['password']);

        $user = $this->registerUserUseCase->execute($userRegister);

        return $this->jsonResponse->success($user, 'User created successfully', 201);
    }
}
