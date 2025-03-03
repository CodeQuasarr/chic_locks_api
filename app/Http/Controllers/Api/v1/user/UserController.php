<?php

namespace App\Http\Controllers\Api\v1\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Resources\User\UserCollection;
use App\Interfaces\User\UserServiceInterface;
use App\Models\User;
use App\Models\User\Role;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userCreationService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        Gate::authorize('viewAny', $request->user());
        return response()->json(new UserCollection(User::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        Gate::authorize('create', $request->user());
        try {
            $user = $this->userCreationService->create($request->all());

            $user->roles()->attach(Role::query()->where('name', Role::CLIENT)->first()->id);


            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
