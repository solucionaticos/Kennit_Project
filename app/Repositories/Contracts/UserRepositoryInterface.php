<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * @param  array<string, string>  $data
     */
    public function create(array $data): User;

    /**
     * @return Collection<User>
     */
    public function getAll(): Collection;
}
