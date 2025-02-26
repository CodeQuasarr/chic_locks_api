<?php

namespace App\Interfaces\Auth;

use App\Models\User;

interface LoginServiceInterface
{

    /**
     * @description Authenticate user
     *
     * @param string $email
     * @param string $password
     * @return array<string, mixed>
     */
    public function authenticate(string $email, string $password): array;

    /**
     * @description Get user by email
     *
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User;
}
