<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    // init roles and permissions
    Artisan::call('update:roles-permissions');

    $this->admin = User::factory()->admin()->create();
    $this->client = User::factory()->client()->create();
    $this->moderator = User::factory()->moderator()->create();

    $this->userData = User::factory()->make()->toArray();
    $this->userData['password'] = 'password';
    $this->userData['password_confirmation'] = 'password';
});

test('admin user can create a user', function () {
    Sanctum::actingAs($this->admin);

    $response = post(route('users.store'), $this->userData, [
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(ResponseAlias::HTTP_CREATED);
    $this->assertDatabaseHas('users', [
        'email' => $this->userData['email'],
    ]);
});

test('Admin user can not create a user with invalid data', function () {
    Sanctum::actingAs($this->admin);

    $this->userData['email'] = 'invalid-email';

    $response = post(route('users.store'), $this->userData, [
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    $this->assertDatabaseMissing('users', [
        'email' => $this->userData['email'],
    ]);
});
test('moderator user cannot create a user', function () {
    Sanctum::actingAs($this->moderator);

    $response = post(route('users.store'), $this->userData, [
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(ResponseAlias::HTTP_FORBIDDEN);
    $this->assertDatabaseMissing('users', [
        'email' => $this->userData['email'],
    ]);
});

test('non-admin user cannot create a user', function () {
    Sanctum::actingAs($this->client);

    $response = post(route('users.store'), $this->userData, [
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(ResponseAlias::HTTP_FORBIDDEN);
    $this->assertDatabaseMissing('users', [
        'email' => $this->userData['email'],
    ]);
});
