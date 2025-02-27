<?php

use App\Models\User;

test('user can register with valid data', function () {
    $user = User::factory()->make([
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response = $this->post(route('user.register'), $user->toArray());

    $response
        ->assertStatus(201)
        ->assertJsonStructure(['message']);
});

test('user cannot register with invalid data', function () {
    $user = User::factory()->make([
        'password' => 'password',
        'password_confirmation' => 'password123',
    ]);

    $response = $this->post(route('user.register'), $user->toArray());

    $response
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors']);
});

test('user cannot register with existing email', function () {

    $existingUser = User::factory()->create([
        'email' => 'existe@exemple.fr',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = User::factory()->make([
        'email' => 'existe@exemple.fr',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response = $this->post(route('user.register'), $user->toArray());

    $response
        ->assertStatus(422)
        ->assertJsonStructure(['message', 'errors']);
});
