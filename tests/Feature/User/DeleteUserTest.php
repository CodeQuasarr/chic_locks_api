<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

beforeEach(function () {
    // init roles and permissions
    Artisan::call('update:roles-permissions');

    $this->admin = User::factory()->admin()->create();
    $this->client = User::factory()->client()->create();
    $this->moderator = User::factory()->moderator()->create();
});

test('admin can delete their own and other users', function () {
    Sanctum::actingAs($this->admin);

    $response = $this->delete(
        route('users.delete', ['user' => $this->admin->getKey()]),
        [],
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );
    $response->assertStatus(ResponseAlias::HTTP_OK);

    $response = $this->delete(
        route('users.delete', ['user' => $this->client->getKey()]),
        [],
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );
    $response->assertStatus(ResponseAlias::HTTP_OK);
});

//    test('admin can force delete their own and other users', function () {
//        Sanctum::actingAs($this->admin);
//
//        $response = $this->delete(route('users.destroy', $this->admin->getKey()), ['Accept' => 'application/json']);
//        $response->assertStatus(ResponseAlias::HTTP_OK);
//
//        $response = $this->delete(route('users.destroy', $this->client->getKey()), ['Accept' => 'application/json']);
//        $response->assertStatus(ResponseAlias::HTTP_OK);
//    });

test('moderator can not delete their information and other users information', function () {
    Sanctum::actingAs($this->moderator);


    $response = $this->delete(
        route('users.delete', ['user' => $this->moderator->getKey()]),
        [],
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );
    $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);


    $response = $this->delete(
        route('users.delete', ['user' => $this->client->getKey()]),
        [],
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );
    $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);


    $response = $this->delete(
        route('users.delete', ['user' => $this->admin->getKey()]),
        [],
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );
    $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
});

test('client can delete only their information', function () {
    Sanctum::actingAs($this->client);


    $response = $this->delete(
        route('users.delete', ['user' => $this->client->getKey()]),
        [],
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );
    $response->assertStatus(ResponseAlias::HTTP_OK);


    $response = $this->delete(
        route('users.delete', ['user' => $this->admin->getKey()]),
        [],
        ['Accept' => 'application/json', 'Accept-Language' => 'en']
    );
    $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
});
