<?php

namespace App\Interfaces\Auth;

use App\Models\User;

interface RegisterServiceInterface
{

    /**
     * @param array $data
     * @return User
     */
    public function register(array $data): User;

}
