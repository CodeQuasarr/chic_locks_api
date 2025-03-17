<?php

namespace App\Interfaces\Auth;

use App\Models\User;

interface LoginServiceInterface
{

    public function passwordCheck(string $password, User $user): void;

}
