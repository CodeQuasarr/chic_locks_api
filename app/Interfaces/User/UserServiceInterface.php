<?php

namespace App\Interfaces\User;

use App\Models\User;

interface UserServiceInterface
{

    public function create(array $data): User;

    public function showById(int $id): User;
}
