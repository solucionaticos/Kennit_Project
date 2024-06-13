<?php

namespace App\Services\Contracts;

interface EncryptionInterface
{
    public function encrypt(string $data): string;
}
