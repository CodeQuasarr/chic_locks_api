<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private User $user)
    {}

    /**
     * Find a user by email.
     */
    public function findByEmail(string $email): ?User
    {
        return $this->user->fieldValue('email', $email)->first();
    }
}
