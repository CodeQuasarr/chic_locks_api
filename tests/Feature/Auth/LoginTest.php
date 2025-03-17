<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('login with valid credentials', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $response = $this->post(route('user.login'), [
        'email' => $user->email,
        'password' => 'password',
    ], ['Accept' => 'application/json', 'Accept-Language' => 'en']);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data',
        'meta',
    ]);
});

test('User can not login with invalid credentials', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $response = $this->post(route('user.login'), [
        'email' => $user->email,
        'password' => 'password123',
    ], ['Accept' => 'application/json', 'Accept-Language' => 'en']);

    $response->assertStatus(401)
        ->assertJsonStructure(['errors', 'meta']);

});

test('Brute force attack is blocked', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    foreach (range(1, 10) as $i) {
        $response = $this->post(route('user.login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ],['Accept' => 'application/json', 'Accept-Language' => 'en']);
    }

    $response->assertStatus(429);
});

test('SQL injection attempt fails', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);
    $response = $this->post(route('user.login'), [
        'email' => "' OR 1=1; --",
        'password' => 'anything',
    ], ['Accept' => 'application/json', 'Accept-Language' => 'en']);
    $response->assertStatus(422); // Doit refuser l'accès
});
