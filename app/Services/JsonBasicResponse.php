<?php

namespace App\Services;

use App\Services\Contracts\JsonResponseInterface;
use Illuminate\Http\JsonResponse;

class JsonBasicResponse implements JsonResponseInterface
{
    public function success(mixed $data, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public function error(string $message = 'Error', int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
        ], $statusCode);
    }
}
