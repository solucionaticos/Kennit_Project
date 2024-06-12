<?php

namespace App\Contracts;

interface JsonResponseServiceInterface
{
    public function success($data, $message = 'Success', $statusCode = 200);
    public function error($message = 'Error', $statusCode = 400);
}