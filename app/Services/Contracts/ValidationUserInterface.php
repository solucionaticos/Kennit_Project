<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;

interface ValidationUserInterface
{
    public function validate(array $data): JsonResponse|array;
}
