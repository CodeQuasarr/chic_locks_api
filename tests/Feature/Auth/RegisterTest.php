<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    // init roles and permissions
    Artisan::call('update:roles-permissions');

    $this->userData = User::factory()->make()->toArray();
    $this->userData['password'] = 'password';
    $this->userData['password_confirmation'] = 'password';
});

test('user can register with valid data', function () {

    $response = $this->post(
        route('user.register'),
        $this->userData,
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );

    $response
        ->assertStatus(201)
        ->assertJsonStructure(['data', 'meta']);
});

test('user cannot register with invalid data', function () {

    $this->userData['password_confirmation'] = 'password123';

    $response = $this->post(
        route('user.register'),
        $this->userData,
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );

    $response
        ->assertStatus(422)
        ->assertJsonStructure(['errors', 'meta']);
});

test('user cannot register with existing email', function () {

    $existingUser = User::factory()->create([
        'email' => 'existe@exemple.fr',
        'password' => 'password',
    ]);

    $credentials = [
        'name' => 'John Doe',
        'email' => 'existe@exemple.fr',
        'password' => 'password',
        'password_confirmation' => 'password123',
    ];

    $response = $this->post(
        route('user.register'),
        $credentials,
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );

    $response
        ->assertStatus(422)
        ->assertJsonStructure(['errors', 'meta']);
});
