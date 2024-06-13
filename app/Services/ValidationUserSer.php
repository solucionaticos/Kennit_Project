<?php

namespace App\Services;

use App\Services\Contracts\ValidationUserInterface;
use App\Services\Contracts\JsonResponseInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class ValidationUserSer implements ValidationUserInterface
{

    private $jsonResponse;

    public function __construct(JsonResponseInterface $jsonResponse)
    {
        $this->jsonResponse = $jsonResponse;
    }

    public function validate(array $data): JsonResponse|array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse->error($validator->errors()->first(), 422);
        }

        return $validator->validated();
    }
}
