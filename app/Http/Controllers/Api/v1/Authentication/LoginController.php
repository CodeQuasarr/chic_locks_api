<?php

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\Auth\LoginServiceInterface;
use App\Interfaces\Auth\TokenServiceInterface;
use Illuminate\Http\JsonResponse;

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

            $token = $this->tokenService->generateToken($user);

            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
