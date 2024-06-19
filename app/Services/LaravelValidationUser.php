<?php

namespace App\Services;

use App\Services\Contracts\JsonResponseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class LaravelValidationUser
{
    public function __construct(private readonly JsonResponseInterface $jsonResponse)
    {
    }

    public function validate(array $data): JsonResponse|array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse->error($validator->errors()->first(), 422);
        }

        return $validator->validated();
    }
}
