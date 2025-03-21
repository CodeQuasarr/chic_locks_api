<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Auth\RegisterServiceInterface;
use App\Models\User\Role;
use App\Responses\ApiResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    public function __construct(
        private readonly RegisterServiceInterface $registerService,
    )
    {}

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
                    "name" => $user->name,
                    "email" => $user->email,
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
