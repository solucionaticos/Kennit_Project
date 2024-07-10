<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\JsonResponse;

interface ProductRepositoryInterface
{
    public function getAll(): JsonResponse;

    public function show(int $id): JsonResponse;

    public function create(array $data): JsonResponse;

    public function update(int $id, array $data): JsonResponse;

    public function delete(int $id): JsonResponse;
}
