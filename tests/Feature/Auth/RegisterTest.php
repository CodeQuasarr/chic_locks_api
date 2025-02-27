<?php

use App\Models\User;

test('user can register with valid data', function () {
    $credentials = [
        'name' => 'John Doe',
        'email' => 'test@exemple.fr',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->post(route('user.register'), $credentials, [
        'Accept' => 'application/json',
    ]);

    $response
        ->assertStatus(201)
        ->assertJsonStructure(['message']);
});

test('user cannot register with invalid data', function () {
    $credentials = [
        'name' => 'John Doe',
        'email' => 'test@exemple.fr',
        'password' => 'password',
        'password_confirmation' => 'password123',
    ];

    $response = $this->post(route('user.register'), $credentials, [
        'Accept' => 'application/json',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors']);
});

test('user cannot register with existing email', function () {

    $existingUser = User::factory()->create([
        'email' => 'existe@exemple.fr',
        'password' => 'password',
    ]);

    $credentials = [
        'name' => 'John Doe',
        'email' => 'test@exemple.fr',
        'password' => 'password',
        'password_confirmation' => 'password123',
    ];

    $response = $this->post(route('user.register'),  $credentials, [
        'Accept' => 'application/json',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors']);
});
