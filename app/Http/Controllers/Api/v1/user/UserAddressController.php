<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserAddressStoreRequest;
use App\Interfaces\User\UserAddressServiceInterface;
use App\Models\User;
use App\Models\User\UserAddress;
use App\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserAddressController extends Controller
{

    public function __construct(private UserAddressServiceInterface $userAddressService)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddressStoreRequest $request, User $user): JsonResponse
    {
        Gate::authorize('create', UserAddress::class);


        $this->userAddressService->create($request->user(), $user, $request->all());
        return response()->json(['message' => 'User address created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
