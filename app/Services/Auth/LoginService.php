<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\LoginServiceInterface;
use App\Models\User;
use RuntimeException;

class LoginService implements LoginServiceInterface
{
    public function __construct(){}

    public function passwordCheck(string $password, User $user): void
    {
        if (!\Hash::check($password, $user->password)) {
            throw new RuntimeException(__("auth.failed"), 401);
        }
    }

}
