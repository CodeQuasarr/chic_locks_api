<?php

namespace App\Interfaces\Auth;

use App\Models\User;

interface TokenServiceInterface
{

    public function generateToken(User $user): string;
}
