<?php

use App\Models\User;
use App\Models\Users\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    Artisan::call('update:roles-permissions');

    $this->admin = User::factory()->admin()->create();
    $this->client = User::factory()->client()->create();
    $this->moderator = User::factory()->moderator()->create();
    $this->addressData = UserAddress::factory()->make()->toArray();
});

it('allows users to create addresses', function ($user) {
    Sanctum::actingAs($user);

    $response = post(
        route('addresses.store', ['user' => $user->id]),
        $this->addressData, [
            'Accept' => 'application/json',
            'Accept-Language' => 'en'
        ]
    );

    $response->assertStatus(ResponseAlias::HTTP_CREATED);
    $this->assertDatabaseHas('user_addresses', $this->addressData);
})->with([
    'admin' => fn() => $this->admin,
    'moderator' => fn() => $this->moderator,
    'client' => fn() => $this->client,
]);

it('rejects invalid address data', function ($user) {
    Sanctum::actingAs($user);

    $invalidData = array_merge($this->addressData, ['is_default' => 'invalid']);

    $response = post(
        route('addresses.store', ['user' => $user->id]),
        $invalidData, [
            'Accept' => 'application/json',
            'Accept-Language' => 'en'
        ]
    );

    $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
})->with([
    'admin' => fn() => $this->admin,
    'moderator' => fn() => $this->moderator,
    'client' => fn() => $this->client,
]);

test('A user cannot create an address for another user', function () {
    Sanctum::actingAs($this->client);
    $user = User::factory()->create();

    $response = post(
        route('addresses.store', ['user' => $user->id]),
        $this->addressData, [
            'Accept' => 'application/json',
            'Accept-Language' => 'en'
        ]
    );

    $response->assertStatus(ResponseAlias::HTTP_FORBIDDEN);
});

test('A user can have only one default address', function () {
    Sanctum::actingAs($this->client);

    // Création d'une première adresse par défaut
    UserAddress::factory()->create([
        'user_id' => $this->client->id,
        'is_default' => true,
    ]);

    // Tentative d'ajout d'une seconde adresse par défaut
    $this->addressData['is_default'] = true;
    $response = post(
        route('addresses.store', ['user' => $this->client->id]),
        $this->addressData, [
            'Accept' => 'application/json',
            'Accept-Language' => 'en'
        ]
    );

    $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
});
