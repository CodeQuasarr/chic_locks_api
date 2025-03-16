<?php

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\Auth\LoginServiceInterface;
use App\Interfaces\Auth\TokenServiceInterface;
use App\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct(
        private readonly LoginServiceInterface $loginService,
        private readonly TokenServiceInterface $tokenService
    )
    {
    }

    /**
     * @description Authenticate user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $user = $this->loginService->getUserByEmail($request->get('email'));
            $request->authenticate($user, $request->get('password'));

            $refreshToken = $this->tokenService->generateRefreshToken($user, 'refresh_token');
            $accessToken = $this->tokenService->generateToken($user, 'access_token');

            return response()->json([
                'token' => $accessToken,
                'token_type' => 'Bearer',
                'user' => $user,
                'message' => 'User authenticated',
            ])
                ->cookie(
                    'refresh_token',
                    $refreshToken,
                    60 * 24 * 7,   // 7 jours
                    '/',
                    'chic_locks_api.test',  // Définit le domaine explicitement
                    true,   // Secure=true (HTTPS obligatoire)
                    true,   // HttpOnly=true (Empêche l'accès depuis JavaScript)
                    false,  // Pas de raw cookie
                    'None'  // SameSite=None (Autorise le partage entre domaines différents)
                );
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 'auth_error', $e->getCode());
        }
    }

    public function refresh(Request $request): JsonResponse
    {
        try {
            $refreshToken = $request->cookie('refresh_token');
            $userAndAccessToken = $this->loginService->refreshAccessToken($refreshToken);
            return ApiResponse::success(['token' => $userAndAccessToken['token'], 'user' => $userAndAccessToken['user']], 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 'auth_error', $e->getCode());
        }
    }
}
