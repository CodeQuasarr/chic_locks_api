<?php

use App\Models\User;
use App\Models\User\Role;
use Illuminate\Support\Facades\Artisan;

beforeEach(
    function () {
        // call command update:roles-permissions to create roles and permissions
        Artisan::call('update:roles-permissions');
});

test('Admin can get users', function () {
    $user = User::factory()->admin()->create();
    $token = $user->createToken('api.token')->plainTextToken;

    $response = $this
        ->withHeader('Authorization', "Bearer $token")
        ->get(route('users.index'));

    $response->assertStatus(200);
});


test('Moderator can get users', function () {
    $user = User::factory()->moderator()->create();
    $token = $user->createToken('api.token')->plainTextToken;

    $response = $this
        ->withHeader('Authorization', "Bearer $token")
        ->get(route('users.index'));

    $response->assertStatus(200);
});


test('Client can not get users', function () {
    $user = User::factory()->create();
    $token = $user->createToken('api.token')->plainTextToken;

    $response = $this
        ->withHeader('Authorization', "Bearer $token")
        ->get(route('users.index'));

    $response->assertStatus(403);
});

test('Guest can not get users', function () {
    $response = $this->get(route('users.index'));

    // message est This action is unauthorized.
    $response->assertSee('You are not authorized to access this resource.');
});
