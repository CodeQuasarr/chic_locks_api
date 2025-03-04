<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

describe('Editing user information', function () {

    beforeEach(function () {
        // init roles and permissions
        Artisan::call('update:roles-permissions');

        $this->admin = User::factory()->admin()->create();
        $this->client = User::factory()->client()->create();
        $this->moderator = User::factory()->moderator()->create();

        $this->userData['name'] = 'John Doe';
        $this->userData['password'] = 'password';
        $this->userData['password_confirmation'] = 'password';
    });

    test('admin can edit their own information and other users information', function () {
        Sanctum::actingAs($this->admin);

        $response = $this->put(route('users.update', $this->admin->getKey()), $this->userData, ['Accept' => 'application/json']);
        $response->assertStatus(ResponseAlias::HTTP_OK);


        $response = $this->put(route('users.update', $this->client->getKey()), $this->userData, ['Accept' => 'application/json']);
        $response->assertStatus(ResponseAlias::HTTP_OK);
    });

    test('moderator can edit their own information and other users information but not admin information', function () {
        Sanctum::actingAs($this->moderator);


        $response = $this->put(route('users.update', $this->moderator->getKey()), $this->userData, ['Accept' => 'application/json']);
        $response->assertStatus(ResponseAlias::HTTP_OK);


        $response = $this->put(route('users.update', $this->client->getKey()), $this->userData, ['Accept' => 'application/json']);
        $response->assertStatus(ResponseAlias::HTTP_OK);


        $response = $this->put(route('users.update', $this->admin->getKey()), $this->userData, ['Accept' => 'application/json']);
        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    });

    test('client can edit only their own information', function () {
        Sanctum::actingAs($this->client);


        $response = $this->put(route('users.update', $this->client->getKey()), $this->userData, ['Accept' => 'application/json']);
        $response->assertStatus(ResponseAlias::HTTP_OK);


        $response = $this->put(route('users.update', $this->admin->getKey()), $this->userData, ['Accept' => 'application/json']);
        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    });
});
