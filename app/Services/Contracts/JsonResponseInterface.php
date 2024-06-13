<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;

interface JsonResponseInterface
{
    public function success(mixed $data, string $message = 'Success', int $statusCode = 200): JsonResponse;
    public function error(string $message = 'Error', int $statusCode = 400): JsonResponse;
}
