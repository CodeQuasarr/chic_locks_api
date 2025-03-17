<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\TokenServiceInterface;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class TokenService implements TokenServiceInterface
{
    public function generateToken(User $user, string $title): string
    {
        return $user->createToken($title, ['*'], now()->addMinutes(15))->plainTextToken;
    }

    public function generateRefreshToken(User $user, string $title): string
    {
        return $user->createToken($title, ['*'], Carbon::now()->addMinutes(15))->plainTextToken;
    }

    public function validateRefreshToken(string $refreshToken): PersonalAccessToken
    {
        if (!$refreshToken) {
            throw new RuntimeException('Invalid or missing credentials', Response::HTTP_UNAUTHORIZED);
        }

        $tokenModel = PersonalAccessToken::findToken($refreshToken);
        if (!$tokenModel || !$tokenModel->can('refresh')) {
            throw new RuntimeException('Invalid or missing credentials', Response::HTTP_UNAUTHORIZED);
        }

        return $tokenModel;
    }

    public function deleteExpiredToken(PersonalAccessToken $tokenModel): void
    {
        $expiration = Carbon::parse($tokenModel->expires_at);
        if ($expiration->isPast()) {
            $tokenModel->tokenable->tokens()->delete();
            throw new RuntimeException('Invalid or missing credentials', Response::HTTP_UNAUTHORIZED);
        }
    }

    public function refreshAccessToken(string $refreshToken): string
    {
        $tokenModel = $this->validateRefreshToken($refreshToken);
        $this->deleteExpiredToken($tokenModel);

        $user = $tokenModel->tokenable;
        return $this->generateToken($user, 'access_token');
    }
}
