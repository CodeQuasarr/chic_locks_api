<?php

namespace App\Interfaces\Users;

use App\Models\User;
use App\Models\Users\UserAddress;

interface UserAddressServiceInterface
{
    public function create(User $authUser, User $user, array $data): UserAddress;

    public function update(array $data, string $id): void;

    public function delete(string $id): void;

    public function attach($model, $relation, $data): void;
}
