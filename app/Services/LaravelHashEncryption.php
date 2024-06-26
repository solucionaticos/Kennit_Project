<?php

namespace App\Services;

use App\Services\Contracts\EncryptionInterface;
use Illuminate\Support\Facades\Hash;

class LaravelHashEncryption implements EncryptionInterface
{
    public function encrypt(string $data): string
    {
        return Hash::make($data);
    }
}
