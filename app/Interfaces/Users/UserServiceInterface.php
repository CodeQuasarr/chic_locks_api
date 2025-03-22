<?php

namespace App\Interfaces\Users;

use App\Models\User;

interface UserServiceInterface
{


    /**
     * @description Get user by email
     *
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User;

    public function createUser(array $data): User;

    public function showUserById(int $id): User;

    public function updateUser(array $data, User $user): User;
}
