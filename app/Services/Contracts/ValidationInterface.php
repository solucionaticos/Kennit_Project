<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;

interface ValidationInterface
{
    public function validate(array $data): JsonResponse|array;
}
