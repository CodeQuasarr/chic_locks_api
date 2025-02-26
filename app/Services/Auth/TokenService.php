<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\TokenServiceInterface;
use App\Models\User;

class TokenService implements TokenServiceInterface
{
    public function generateToken(User $user): string
    {
        return $user->createToken('api.token')->plainTextToken;
    }
}
