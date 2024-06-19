<?php

namespace App\useCases;

use App\Models\DTOs\UserRegisterDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\EncryptionInterface;

class RegisterUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EncryptionInterface $encryption
    ) {
    }

    public function execute(UserRegisterDTO $userRegister): User
    {
        $hashedPassword = $this->encryption->encrypt($userRegister->getUserPassword());

        $user = $this->userRepository->create([
            'name' => $userRegister->getName(),
            'email' => $userRegister->getEmail(),
            'password' => $hashedPassword,
        ]);

        /*
         * Yo podría necesitar hacer N cosas más
         * - Enviar un correo de bienvenida
         * - Enviar una notificación push
         * - Agregarle un cupon de bienvenida
         * - etc...
         */

        return $user;
    }
}
