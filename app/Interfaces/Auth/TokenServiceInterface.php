<?php

namespace App\Interfaces\Auth;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

interface TokenServiceInterface
{

    public function generateToken(User $user, string $title): string;

    public function generateRefreshToken(User $user, string $title): string;

    public function validateRefreshToken(string $refreshToken): PersonalAccessToken;

    public function deleteExpiredToken(PersonalAccessToken $tokenModel): void;

    public function refreshAccessToken(string $refreshToken): array;
}
