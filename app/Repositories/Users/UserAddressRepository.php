<?php

namespace App\Repositories\Users;


use App\Models\User;
use App\Models\Users\UserAddress;

class UserAddressRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private readonly UserAddress $userAddress)
    {}

    public function getInstanceOfUser(): \App\Models\Users\UserAddress
    {
        return $this->userAddress;
    }

    /**
     * Find a user by email.
     */
    public function findByUser(int $userId): ?\App\Models\Users\UserAddress
    {
        return $this->userAddress->fieldValue('user_id', $userId);
    }

    /**
     * Create a new user.
     */
    public function create(User $user, array $data): ?UserAddress
    {
        return $user->addresses()->create($data);
    }

    /**
     * Find a user by ID.
     */
    public function getById(int $id): ?\App\Models\Users\UserAddress
    {
        return $this->userAddress->find($id);
    }

    /**
     * Update a user.
     */
    public function update(array $data, UserAddress $userAddress): bool
    {
        return $userAddress->update($data);
    }
}
