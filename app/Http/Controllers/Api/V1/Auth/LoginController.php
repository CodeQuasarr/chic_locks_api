<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Users\UserResource;
use App\Interfaces\Auth\TokenServiceInterface;
use App\Interfaces\Users\UserServiceInterface;
use App\Responses\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct(
        private readonly TokenServiceInterface $tokenService,
        private readonly UserServiceInterface  $userService
    )
    {
    }

    /**
     * @description Authenticate user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $user = $this->userService->getUserByEmail($request->get('email'));

        $request->authenticate($user, $request->get('password'));

        $refreshToken = $this->tokenService->generateRefreshToken($user, 'refresh_token');
        $accessToken = $this->tokenService->generateToken($user, 'access_token');

        return ApiResponse::success([
            'data' => [
                "type" => "tokens",
                "id" => "jwt_token_abc123xyz",
                "attributes" => [
                    "token" => $accessToken,
                ],
                "links" => [
                    "self" => "/auth/login"
                ]
            ],
            "meta" => [
                "message" => "Authentification réussie"
            ]
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
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return ApiResponse::success(new UserResource($user), 200);
    }

    public function refresh(Request $request): JsonResponse
    {
        $refreshToken = $request->cookie('refresh_token');
        $accessToken = $this->tokenService->refreshAccessToken($refreshToken);
        return ApiResponse::success([
            'data' => [
                "type" => "tokens",
                "id" => "jwt_token_abc123xyz",
                "attributes" => [
                    "token" => $accessToken,
                ],
                "links" => [
                    "self" => "/auth/login"
                ]
            ],
            "meta" => [
                "message" => "Authentification réussie"
            ]
        ], 200);
    }
}
