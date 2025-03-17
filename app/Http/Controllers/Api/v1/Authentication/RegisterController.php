<?php

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Auth\LoginServiceInterface;
use App\Interfaces\Auth\RegisterServiceInterface;
use App\Interfaces\Auth\TokenServiceInterface;
use App\Models\User\Role;
use App\Responses\ApiResponse;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{

    public function __construct(
        private readonly RegisterServiceInterface $registerService,
    )
    {
    }

    /**
     * @description Authenticate user
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        $user = $this->registerService->register($request->all());
        event(new Registered($user));
        $user->assignRole(Role::CLIENT);
        return ApiResponse::success([
            "data" => [
                "type" => "users",
                "id" => $user->getKey(),
                "attributes" => [
                    "first_name" => "John",
                    "last_name" => "Doe",
                    "email" => "john.doe@example.com",
                    "created_at" => "2025-03-16T12:34:56Z",
                    "updated_at" => "2025-03-16T12:34:56Z",
                    "confirmation_status" => "pending"
                ],
                "links" => [
                    "self" => "/users/123"
                ]
            ],
            "meta" => [
                "message" => "Utilisateur créé. Veuillez confirmer votre email pour activer votre compte."
            ]
        ],  201);
    }
}
