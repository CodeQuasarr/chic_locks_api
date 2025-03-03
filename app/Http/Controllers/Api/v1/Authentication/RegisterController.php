<?php

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Auth\LoginServiceInterface;
use App\Interfaces\Auth\RegisterServiceInterface;
use App\Interfaces\Auth\TokenServiceInterface;
use App\Models\User\Role;
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
        try {
            DB::beginTransaction();
            $user = $this->registerService->register($request->all());
            event(new Registered($user));

            $user->assignRole(Role::CLIENT);
            DB::commit();
            return response()->json([
                'message' => 'User registered. Please verify your email address.',
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
