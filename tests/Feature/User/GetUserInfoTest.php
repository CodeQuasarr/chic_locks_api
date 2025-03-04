<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

describe('Managing user information', function () {

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

    test('admin can access their own information and other users information', function () {
        Sanctum::actingAs($this->admin);

        // Accéder aux informations de l'admin lui-même
        $response = $this->get(route('users.show', $this->admin->id));
        $response->assertStatus(ResponseAlias::HTTP_OK);

        // Accéder aux informations d'un autre utilisateur
        $response = $this->get(route('users.show', $this->client->id));
        $response->assertStatus(ResponseAlias::HTTP_OK);
    });

    test('moderator can access their own information and other users information but not admin information', function () {
        Sanctum::actingAs($this->moderator);

        // Accéder aux informations du modérateur lui-même
        $response = $this->get(route('users.show', $this->moderator->id));
        $response->assertStatus(ResponseAlias::HTTP_OK);

        // Accéder aux informations d'un autre utilisateur (client)
        $response = $this->get(route('users.show', $this->client->id));
        $response->assertStatus(ResponseAlias::HTTP_OK);

        // Essayer d'accéder aux informations de l'admin (devrait échouer)
        $response = $this->get(route('users.show', $this->admin->id));
        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    });

    test('client can access only their own information', function () {
        Sanctum::actingAs($this->client);

        // Accéder aux informations du client lui-même
        $response = $this->get(route('users.show', $this->client->id));
        $response->assertStatus(ResponseAlias::HTTP_OK);

        // Essayer d'accéder aux informations d'un autre utilisateur (devrait échouer)
        $response = $this->get(route('users.show', $this->admin->id));
        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    });
});
