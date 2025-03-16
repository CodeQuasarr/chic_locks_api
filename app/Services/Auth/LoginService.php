<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\LoginServiceInterface;
use App\Models\User;
use App\Repositories\User\UserRepository;

class LoginService implements LoginServiceInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TokenService   $tokenService
    )
    {}

    /**
     * @description Authenticate user
     *
     * @param string $email
     * @param string $password
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function authenticate(string $email, string $password): array
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new \Exception('User not found', 404);
        }

        if (!\Hash::check($password, $user->password)) {
            throw new \Exception(__("auth.failed"), 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }

    public function refreshAccessToken(string $refreshToken): array
    {
        $tokenModel = $this->tokenService->validateRefreshToken($refreshToken);
        $this->tokenService->deleteExpiredToken($tokenModel);

        $user = $tokenModel->tokenable;
        $newToken = $this->tokenService->generateToken($user, 'access_token');

        return [
            'token' => $newToken,
            'user' => $user,
        ];
    }

    /**
     * @description Get user by email
     *
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new \RuntimeException(__("auth.failed"), 403);
        }

       return $user;
    }
}
