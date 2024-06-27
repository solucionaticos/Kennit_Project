<?php

namespace App\Services;

use App\Services\Contracts\JsonResponseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class LaravelValidationProduct
{
    public function __construct(private JsonResponseInterface $jsonResponse)
    {
    }

    public function validate(array $data): JsonResponse|array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse->error($validator->errors()->first(), 422);
        }

        return $validator->validated();
    }
}
