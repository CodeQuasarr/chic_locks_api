<?php

use App\Models\User;
use App\Models\User\Role;

beforeEach(
    function () {
    Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'api']);
    Role::firstOrCreate(['name' => 'moderator', 'guard_name' => 'api']);
    Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);
});

test('Admin can get users', function () {
    $user = User::factory()->admin()->create();
    $token = $user->createToken('api.token')->plainTextToken;

    $response = $this
        ->withHeader('Authorization', "Bearer $token")
        ->get(route('user.index'));

    $response->assertStatus(200);
});


test('Moderator can get users', function () {
    $user = User::factory()->moderator()->create();
    $token = $user->createToken('api.token')->plainTextToken;

    $response = $this
        ->withHeader('Authorization', "Bearer $token")
        ->get(route('user.index'));

    $response->assertStatus(200);
});


test('User can not get users', function () {
    $user = User::factory()->create();
    $token = $user->createToken('api.token')->plainTextToken;

    $response = $this
        ->withHeader('Authorization', "Bearer $token")
        ->get(route('user.index'));

    $response->assertStatus(403);
});

test('Guest can not get users', function () {
    $response = $this->get(route('user.index'));

    $response->assertStatus(401);
});
