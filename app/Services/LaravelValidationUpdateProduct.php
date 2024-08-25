<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LaravelValidationUpdateProduct
{
    /**
     * @throws ValidationException
     */
    public function validate(array $data): array|string
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
            return $validator->errors()->first();
        }

        return $validator->validated();
    }
}
