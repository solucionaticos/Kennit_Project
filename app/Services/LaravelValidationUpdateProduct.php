<?php

namespace App\Services;

use App\Services\Contracts\JsonResponseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LaravelValidationUpdateProduct
{
    public function __construct(private JsonResponseInterface $jsonResponse)
    {
    }

    /**
     * @throws ValidationException
     */
    public function validate(array $data): JsonResponse|array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'discount' => 'required|numeric',
            'tax_rate' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse->error($validator->errors()->first(), '', 422);
        }

        return $validator->validated();
    }
}
