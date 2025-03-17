<?php

use App\Models\User;
use App\Models\User\Role;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;

beforeEach(
    function () {
        // call command update:roles-permissions to create roles and permissions
        Artisan::call('update:roles-permissions');
});

test('Admin can get users', function () {
    $user = User::factory()->admin()->create();

    Sanctum::actingAs($user);
    $response = $this->get(route('users.index'), ['Accept' => 'application/json', 'Accept-Language' => 'en']);

    $response->assertStatus(200);
});


test('Moderator can get users', function () {
    $user = User::factory()->moderator()->create();

    Sanctum::actingAs($user);
    $response = $this->get(route('users.index'), ['Accept' => 'application/json', 'Accept-Language' => 'en']);


    $response->assertStatus(200);
});


test('Client can not get users', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);
    $response = $this->get(route('users.index'), ['Accept' => 'application/json', 'Accept-Language' => 'en']);

    $response->assertStatus(401);
});

test('Guest can not get users', function () {
    $response = $this->get(route('users.index'), ['Accept' => 'application/json', 'Accept-Language' => 'en']);

    $response->assertStatus(401);
});
