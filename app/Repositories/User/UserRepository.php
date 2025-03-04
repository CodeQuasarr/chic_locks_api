<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private readonly User $user)
    {}

    public function getInstanceOfUser(): User
    {
        return $this->user;
    }

    /**
     * Find a user by email.
     */
    public function findByEmail(string $email): ?User
    {
        return $this->user->fieldValue('email', $email)->first();
    }

    /**
     * Create a new user.
     */
    public function create(array $data): ?User
    {
        return $this->user->create($data);
    }

    /**
     * Find a user by ID.
     */
    public function getById(int $id): ?User
    {
        return $this->user->find($id);
    }
}
